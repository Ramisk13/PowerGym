<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin can access this section.'
            ], 403);
        }
        
        $users = User :: all();
        return response()->json($users);
    }

    

    public function store(Request $request)
    {
        
    if (auth()->user()->role !== 'admin') {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Only admin can access this section.'
        ], 403);
    }

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'phone' => 'required|string',
        'role' => 'required|in:member,trainer,admin',
    ]);

    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->phone = $validatedData['phone'];
    $user->role = $validatedData['role'];
    $user->password = bcrypt($validatedData['password']);
    $user->save();

    return response()->json([
        'status' => true,
        'message' => 'User created successfully',
        'data' => $user
    ], 201);

    }

   

    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin can access this section.'
            ], 403);
        }
    
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'phone' => 'sometimes|required|string',
            'role' => 'sometimes|required|in:member,trainer,admin',
        ]);
    
        $user->update($validatedData);
    
        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }



    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin can access this section.'
            ], 403);
        }
    
        $user = User::findOrFail($id);
        $user->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
