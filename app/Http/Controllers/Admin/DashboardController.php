<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\KnowledgeEntry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard
        $userCount = User::count();
        $conversationCount = Conversation::count();
        $messageCount = Message::count();
        $knowledgeEntryCount = KnowledgeEntry::count();
        
        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();
        
        // Get recent conversations
        $recentConversations = Conversation::with('user')
                                         ->orderBy('updated_at', 'desc')
                                         ->take(5)
                                         ->get();
        
        // Get message source statistics
        $messageSources = Message::where('role', 'ai')
                               ->select('source', DB::raw('count(*) as count'))
                               ->groupBy('source')
                               ->get();
        
        return view('admin.dashboard', compact(
            'userCount', 
            'conversationCount', 
            'messageCount', 
            'knowledgeEntryCount',
            'recentUsers',
            'recentConversations',
            'messageSources'
        ));
    }
}
