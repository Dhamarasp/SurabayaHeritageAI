<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keyword;
use Illuminate\Support\Facades\Cache;

class KeywordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $status = $request->input('status');
        
        // Surabaya keywords query
        $surabayaQuery = Keyword::where('type', 'surabaya')
                               ->with(['creator', 'updater']);
        
        // History keywords query
        $historyQuery = Keyword::where('type', 'history')
                              ->with(['creator', 'updater']);
        
        // Apply search filter to both queries
        if ($search) {
            $surabayaQuery->where('word', 'like', "%{$search}%");
            $historyQuery->where('word', 'like', "%{$search}%");
        }
        
        // Apply status filter to both queries
        if ($status !== null && $status !== '') {
            $surabayaQuery->where('is_active', $status == '1');
            $historyQuery->where('is_active', $status == '1');
        }
        
        // Apply type filter if specified
        if ($type) {
            if ($type == 'surabaya') {
                $historyQuery->where('id', 0); // Force empty result
            } else if ($type == 'history') {
                $surabayaQuery->where('id', 0); // Force empty result
            }
        }
        
        $surabayaKeywords = $surabayaQuery->orderBy('word')
                                        ->paginate(10, ['*'], 'surabaya_page')
                                        ->withQueryString();
        
        $historyKeywords = $historyQuery->orderBy('word')
                                       ->paginate(10, ['*'], 'history_page')
                                       ->withQueryString();
        
        return view('admin.keywords.index', compact('surabayaKeywords', 'historyKeywords'));
    }

    /**
     * Show the form for creating a new keyword.
     */
    public function create()
    {
        return view('admin.keywords.create');
    }

    /**
     * Store a newly created keyword.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:surabaya,history'],
            'word' => ['required', 'string', 'max:255', 'unique:keywords,word,NULL,id,type,' . $request->type],
            'is_active' => ['boolean'],
        ]);

        Keyword::create([
            'type' => $request->type,
            'word' => strtolower($request->word),
            'is_active' => $request->boolean('is_active', true),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Clear the cache
        Cache::forget('surabaya_keywords');
        Cache::forget('history_keywords');

        return redirect()->route('admin.keywords.index')
                         ->with('success', 'Kata kunci berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified keyword.
     */
    public function edit(Keyword $keyword)
    {
        return view('admin.keywords.edit', compact('keyword'));
    }

    /**
     * Update the specified keyword.
     */
    public function update(Request $request, Keyword $keyword)
    {
        $request->validate([
            'word' => ['required', 'string', 'max:255', 'unique:keywords,word,' . $keyword->id . ',id,type,' . $keyword->type],
            'is_active' => ['boolean'],
        ]);

        $keyword->update([
            'word' => strtolower($request->word),
            'is_active' => $request->boolean('is_active', true),
            'updated_by' => auth()->id(),
        ]);

        // Clear the cache
        Cache::forget('surabaya_keywords');
        Cache::forget('history_keywords');

        return redirect()->route('admin.keywords.index')
                         ->with('success', 'Kata kunci berhasil diperbarui.');
    }

    /**
     * Toggle the active status of the specified keyword.
     */
    public function toggleStatus(Keyword $keyword)
    {
        $keyword->update([
            'is_active' => !$keyword->is_active,
            'updated_by' => auth()->id(),
        ]);

        // Clear the cache
        Cache::forget('surabaya_keywords');
        Cache::forget('history_keywords');

        return redirect()->back()
                         ->with('success', 'Status kata kunci berhasil diubah.');
    }

    /**
     * Remove the specified keyword.
     */
    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        // Clear the cache
        Cache::forget('surabaya_keywords');
        Cache::forget('history_keywords');

        return redirect()->route('admin.keywords.index')
                         ->with('success', 'Kata kunci berhasil dihapus.');
    }
}
