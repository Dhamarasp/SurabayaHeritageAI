<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopularTopic;

class PopularTopicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = PopularTopic::with(['creator', 'updater']);
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('display_text', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status == '1');
        }
        
        $topics = $query->orderBy('order')->paginate(10)->withQueryString();
        
        return view('admin.popular-topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new popular topic.
     */
    public function create()
    {
        return view('admin.popular-topics.create');
    }

    /**
     * Store a newly created popular topic.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'display_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        PopularTopic::create([
            'question' => $request->question,
            'display_text' => $request->display_text,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.popular-topics.index')
                         ->with('success', 'Topik populer berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified popular topic.
     */
    public function edit(PopularTopic $popularTopic)
    {
        return view('admin.popular-topics.edit', compact('popularTopic'));
    }

    /**
     * Update the specified popular topic.
     */
    public function update(Request $request, PopularTopic $popularTopic)
    {
        $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'display_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $popularTopic->update([
            'question' => $request->question,
            'display_text' => $request->display_text,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.popular-topics.index')
                         ->with('success', 'Topik populer berhasil diperbarui.');
    }

    /**
     * Toggle the active status of the specified popular topic.
     */
    public function toggleStatus(PopularTopic $popularTopic)
    {
        $popularTopic->update([
            'is_active' => !$popularTopic->is_active,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->back()
                         ->with('success', 'Status topik populer berhasil diubah.');
    }

    /**
     * Remove the specified popular topic.
     */
    public function destroy(PopularTopic $popularTopic)
    {
        $popularTopic->delete();

        return redirect()->route('admin.popular-topics.index')
                         ->with('success', 'Topik populer berhasil dihapus.');
    }

    /**
     * Reorder popular topics.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'topics' => ['required', 'array'],
            'topics.*' => ['required', 'integer', 'exists:popular_topics,id'],
        ]);

        $topics = $request->input('topics');
        
        foreach ($topics as $order => $id) {
            PopularTopic::where('id', $id)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
