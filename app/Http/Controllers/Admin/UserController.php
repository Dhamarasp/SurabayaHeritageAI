<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
        
    public function index(Request $request)
    {
        $query = User::query();
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Apply role filter
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role_id', $request->role);
        }
        
        // Apply sort
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();
        
        return view('admin.user.index', compact('users', 'roles'));
    }
    
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_id' => 'required|exists:roles,id',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'bio' => $validated['bio'] ?? null,
        ]);
        
        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully.');
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'bio' => $validated['bio'] ?? null,
        ]);
        
        return redirect()->route('user.index')
            ->with('success', 'User updated successfully.');
    }
    
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('user.edit', $user->id)
            ->with('success', 'User password updated successfully.');
    }
    
    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === Auth::user()->id) {
            return redirect()->route('user.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }
}
