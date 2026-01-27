<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->leftJoin('roles', 'users.role', '=', 'roles.code')
            ->select('users.*', 'roles.name as role_name');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('users.phone_number', 'like', "%{$search}%");
            });
        }

        // Sorting
        $allowedSorts = ['id', 'name', 'email', 'created_at'];
        $sortBy = in_array($request->sort_by, $allowedSorts)
            ? $request->sort_by
            : 'users.created_at';

        $sortDirection = $request->sort_direction === 'asc' ? 'asc' : 'desc';

        $users = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        return view('admin.users.index', compact('users', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = DB::table('roles')
            ->where('status', 1)
            ->select('code', 'name')
            ->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique('users', 'email')->whereNull('deleted_at'),
    ],
              Rule::unique('users', 'phone_number')->whereNull('deleted_at'),
            'role'         => ['required', 'exists:roles,code'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load([
            'roleData' => function ($q) {
                $q->select('code', 'name');
            }
        ]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = DB::table('roles')
            ->where('status', 1)
            ->select('code', 'name')
            ->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
          'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique('users', 'email')
            ->ignore($user->id)
            ->whereNull('deleted_at'),
    ],
             'phone_number' => [
        'nullable',
        'string',
        'max:20',
        Rule::unique('users', 'phone_number')
            ->ignore($user->id)
            ->whereNull('deleted_at'),
    ],
            'role'         => ['required', 'exists:roles,code'],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            abort(403, 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
