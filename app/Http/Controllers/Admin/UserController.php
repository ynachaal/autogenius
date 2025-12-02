<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ensure only admins can access
        

        $query = User::query();

        // 1. Search Filtering
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Sorting
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        $allowedSorts = ['id', 'name', 'email', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDirection = (strtolower($sortDirection) === 'asc') ? 'asc' : 'desc';

        $users = $query->orderBy($sortBy, $sortDirection)->paginate(10);

        return view('admin.users.index', compact('users', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ensure only admins can access
     

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure only admins can access
      

        // 1. Validation
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 3. Create the User
        $user = User::create($validatedData);

        // 4. Redirect
        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Ensure only admins can access
        

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Ensure only admins can access
       

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Ensure only admins can access
       

        // 1. Validation
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Hash the password if provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // 3. Update the User
        $user->update($validatedData);

        // 4. Redirect
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Ensure only admins can access
        

        // Prevent self-deletion
        if (Auth::id() === $user->id) {
            abort(403, 'Unauthorized action. You cannot delete your own account.');
        }

        // 1. Delete the User
        $user->delete();

        // 2. Redirect
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Helper method to check if the user is an admin
     */
   
}