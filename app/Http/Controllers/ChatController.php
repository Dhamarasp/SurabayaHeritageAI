<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\PopularTopic;

class ChatController extends Controller
{

    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index(Request $request)
    {
        // Generate or get session ID
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('chat_session_id', $sessionId);
        }
        
        // Get conversation history
        $conversations = $this->chatService->getConversationHistory($sessionId);
        
        // Get active conversation or create a new one
        $activeConversation = $this->chatService->getOrCreateConversation($sessionId);
        
        // Get messages for active conversation
        $messages = $this->chatService->getConversationMessages($activeConversation->id);
        
        // Get popular topics
        $popularTopics = PopularTopic::where('is_active', true)
                                    ->orderBy('order')
                                    ->get();
        
        return view('chat.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'messages' => $messages,
            'popularTopics' => $popularTopics
        ]);
    }

    /**
     * Process a chat message
     */
    public function processMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'use_gemini' => 'nullable|boolean',
            'conversation_id' => 'nullable|integer'
        ]);

        $message = $request->input('message');
        $useGemini = $request->input('use_gemini', false);
        
        // Get or create session ID
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('chat_session_id', $sessionId);
        }
        
        // Get conversation ID or create a new conversation
        $conversationId = $request->input('conversation_id');
        if (!$conversationId) {
            $conversation = $this->chatService->getOrCreateConversation($sessionId);
            $conversationId = $conversation->id;
        }

        try {
            $response = $this->chatService->processPrompt($message, $useGemini, $conversationId);
            $response['conversation_id'] = $conversationId;
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error processing chat message: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi.'
            ], 500);
        }
    }
    
    /**
     * Get conversation history
     */
    public function getHistory(Request $request)
    {
        // Get session ID
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            return response()->json([
                'conversations' => []
            ]);
        }
        
        // Get conversation history
        $conversations = $this->chatService->getConversationHistory($sessionId);
        
        return response()->json([
            'conversations' => $conversations
        ]);
    }
    
    /**
     * Get messages for a conversation
     */
    public function getMessages(Request $request, $conversationId)
    {
        // Validate conversation belongs to this session
        $sessionId = $request->session()->get('chat_session_id');
        $conversation = $this->chatService->getConversationHistory($sessionId)
            ->where('id', $conversationId)
            ->first();
            
        if (!$conversation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversation not found'
            ], 404);
        }
        
        // Get messages
        $messages = $this->chatService->getConversationMessages($conversationId);
        
        return response()->json([
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }
    
    /**
     * Create a new conversation
     */
    public function newConversation(Request $request)
    {
        // Get session ID
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('chat_session_id', $sessionId);
        }
        
        // Create new conversation
        $conversation = $this->chatService->createNewConversation($sessionId);
        
        return response()->json([
            'status' => 'success',
            'conversation' => $conversation
        ]);
    }
}
