<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();
        $users = User::with('role')->get();
        return view('users.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {   
        if ($request->hasFile('profile_image')) {
            $fileName = $request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('profile_image'), $fileName);
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'role_id' => $request->role_id,
            'profile_image' => $fileName ?? null,
        ]);
    
        return response()->json($user, 201);
    }

    public function fetchUsers()
    {
        $users = User::with('role')->get();
        return view('users.data', ['users' => $users])->render();
    }
}
