<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = Conversation::with('user');
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('session_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('messages', function($messageQuery) use ($search) {
                      $messageQuery->where('content', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status == '1');
        }
        
        $conversations = $query->orderBy('updated_at', 'desc')
                             ->paginate(10)
                             ->withQueryString();
                             
        return view('admin.conversations.index', compact('conversations'));
    }

    /**
     * Display the specified conversation.
     */
    public function show(Conversation $conversation)
    {
        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();
        return view('admin.conversations.show', compact('conversation', 'messages'));
    }

    /**
     * Remove the specified conversation.
     */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();

        return redirect()->route('admin.conversations.index')
                         ->with('success', 'Percakapan berhasil dihapus.');
    }
    
    /**
     * Display statistics about conversations.
     */
    public function statistics()
    {
        // Get conversation count by date
        $conversationsByDate = Conversation::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                         ->groupBy('date')
                                         ->orderBy('date', 'desc')
                                         ->limit(30)
                                         ->get();
        
        // Get message count by source
        $messagesBySource = Message::where('role', 'ai')
                                 ->selectRaw('source, COUNT(*) as count')
                                 ->groupBy('source')
                                 ->get();
        
        // Get top users by conversation count
        $topUsersByConversations = Conversation::selectRaw('user_id, COUNT(*) as count')
                                             ->whereNotNull('user_id')
                                             ->groupBy('user_id')
                                             ->orderBy('count', 'desc')
                                             ->limit(10)
                                             ->with('user')
                                             ->get();
        
        return view('admin.conversations.statistics', compact(
            'conversationsByDate',
            'messagesBySource',
            'topUsersByConversations'
        ));
    }
}
