<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\{Conversation, Message, KnowledgeEntry, Keyword};
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function processPrompt(string $prompt, bool $useGemini = false, ?int $conversationId = null): array
    {
        $promptLower = Str::lower($prompt);

        if (!$this->isAboutSurabayaHistory($promptLower)) {
            return $this->respondWithError($conversationId, $prompt);
        }

        $localResponse = $this->checkLocalKnowledge($promptLower);
        if ($localResponse) {
            return $this->respondWithSuccess($conversationId, $prompt, $localResponse, 'local');
        }

        if (!$useGemini) {
            return [
                'status' => 'need_permission',
                'message' => 'Saya tidak memiliki informasi tentang hal tersebut dalam database lokal. Apakah Anda mengizinkan saya untuk mencari jawaban menggunakan API Gemini?',
                'source' => 'local'
            ];
        }

        $geminiResponse = $this->getCachedGeminiResponse($prompt);
        return $this->respondWithSuccess($conversationId, $prompt, $geminiResponse, 'gemini');
    }

    public function getOrCreateConversation($sessionId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $query = Conversation::where('is_active', true);

        $userId ? $query->where('user_id', $userId) : $query->where('session_id', $sessionId);

        return $query->first() ?? Conversation::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'is_active' => true
        ]);
    }

    public function createNewConversation($sessionId, $userId = null)
    {
        $query = Conversation::where('is_active', true);
        $userId = $userId ?? Auth::id();

        $query->update(['is_active' => false]);

        return Conversation::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'is_active' => true
        ]);
    }

    protected function isAboutSurabayaHistory(string $prompt): bool
    {
        $prompt = Str::lower($prompt);

        // Get active Surabaya keywords from database
        $surabayaKeywords = Cache::remember('surabaya_keywords', 3600, function () {
            return Keyword::where('type', 'surabaya')
                        ->where('is_active', true)
                        ->pluck('word')
                        ->toArray();
        });

        // Get active History keywords from database
        $historyKeywords = Cache::remember('history_keywords', 3600, function () {
            return Keyword::where('type', 'history')
                        ->where('is_active', true)
                        ->pluck('word')
                        ->toArray();
        });

        $hasSurabayaContext = collect($surabayaKeywords)        
            ->some(fn($k) => Str::contains($prompt, $k));

        $hasHistoryContext = collect($historyKeywords)
            ->some(fn($k) => Str::contains($prompt, $k));

        return $hasSurabayaContext && $hasHistoryContext;
    }


    protected function checkLocalKnowledge(string $prompt): ?string
    {
        // Ambil semua entri yang aktif
        $entries = KnowledgeEntry::where('is_active', true)->get();

        // Optimasi: ubah prompt jadi lowercase sekali saja
        $promptLower = Str::lower($prompt);

        // Cek satu per satu entri dan keyword-nya
        foreach ($entries as $entry) {
            foreach ($entry->keywords as $keyword) {
                if (Str::contains($promptLower, Str::lower($keyword))) {
                    return $entry->response;
                }
            }
        }

        return null;
    }


    protected function getCachedGeminiResponse(string $prompt): string
    {
        return Cache::remember("gemini_response_" . md5($prompt), 3600, function () use ($prompt) {
            return $this->getResponseFromGemini($prompt);
        });
    }

    protected function getResponseFromGemini(string $prompt): string
    {
        try {
            $apiKey = config('services.gemini.api_key');
            $endpoint = config('services.gemini.endpoint');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey
            ])->post($endpoint, [
                'contents' => [[
                    'parts' => [['text' => "Berikan informasi tentang sejarah Surabaya terkait: $prompt. Jawab dalam Bahasa Indonesia dengan singkat"]]
                ]],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text']
                    ?? $data['candidates'][0]['content']['text']
                    ?? 'Tidak ada jawaban tersedia.';
            }

            Log::error('Gemini API error: ' . $response->body());
            return 'Maaf, terjadi kesalahan saat menghubungi API Gemini.';
        } catch (\Exception $e) {
            Log::error('Gemini API exception: ' . $e->getMessage());
            return 'Maaf, terjadi kesalahan saat menghubungi API Gemini.';
        }
    }

    protected function respondWithError($conversationId, $prompt): array
    {
        $message = 'Maaf, saya hanya dapat menjawab pertanyaan tentang sejarah Surabaya.';
        if ($conversationId) $this->logMessages($conversationId, $prompt, $message, 'local');

        return ['status' => 'error', 'message' => $message, 'source' => 'local'];
    }

    protected function respondWithSuccess($conversationId, $prompt, $response, $source): array
    {
        if ($conversationId) $this->logMessages($conversationId, $prompt, $response, $source);

        return ['status' => 'success', 'message' => $response, 'source' => $source];
    }

    protected function logMessages($conversationId, $userPrompt, $aiResponse, $source): void
    {
        $this->saveMessage($conversationId, 'user', $userPrompt);
        $this->saveMessage($conversationId, 'ai', $aiResponse, $source);
    }

    public function saveMessage($conversationId, $role, $content, $source = null)
    {
        $message = Message::create([
            'conversation_id' => $conversationId,
            'role' => $role,
            'content' => $content,
            'source' => $source
        ]);

        $conversation = Conversation::find($conversationId);
        if ($role === 'user' && $conversation) {
            $conversation->generateTitle();
        }

        return $message;
    }

    public function getConversationHistory($sessionId, $userId = null)
    {
        $query = Conversation::query();
        $userId ? $query->where('user_id', $userId) : $query->where('session_id', $sessionId);

        return $query->orderBy('updated_at', 'desc')->get();
    }

    public function getConversationMessages($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
