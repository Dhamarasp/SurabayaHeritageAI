<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeEntry;

class KnowledgeEntryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = KnowledgeEntry::with(['creator', 'updater']);
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('topic', 'like', "%{$search}%")
                  ->orWhere('response', 'like', "%{$search}%")
                  ->orWhereJsonContains('keywords', $search);
            });
        }
        
        // Apply status filter
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status == '1');
        }
        
        $entries = $query->orderBy('updated_at', 'desc')->paginate(10)->withQueryString();
        
        return view('admin.knowledge.index', compact('entries'));
    }

    /**
     * Show the form for creating a new knowledge entry.
     */
    public function create()
    {
        return view('admin.knowledge.create');
    }

    /**
     * Store a newly created knowledge entry.
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'keywords' => ['required', 'string'],
            'response' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        // Convert keywords string to array
        $keywords = array_map('trim', explode(',', $request->keywords));

        KnowledgeEntry::create([
            'topic' => $request->topic,
            'keywords' => $keywords,
            'response' => $request->response,
            'is_active' => $request->boolean('is_active', true),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.knowledge.index')
                         ->with('success', 'Entri pengetahuan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified knowledge entry.
     */
    public function edit(KnowledgeEntry $knowledge)
    {
        return view('admin.knowledge.edit', compact('knowledge'));
    }

    /**
     * Update the specified knowledge entry.
     */
    public function update(Request $request, KnowledgeEntry $knowledge)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'keywords' => ['required', 'string'],
            'response' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        // Convert keywords string to array
        $keywords = array_map('trim', explode(',', $request->keywords));

        $knowledge->update([
            'topic' => $request->topic,
            'keywords' => $keywords,
            'response' => $request->response,
            'is_active' => $request->boolean('is_active', true),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.knowledge.index')
                         ->with('success', 'Entri pengetahuan berhasil diperbarui.');
    }

    /**
     * Remove the specified knowledge entry.
     */
    public function destroy(KnowledgeEntry $knowledge)
    {
        $knowledge->delete();

        return redirect()->route('admin.knowledge.index')
                         ->with('success', 'Entri pengetahuan berhasil dihapus.');
    }
}
