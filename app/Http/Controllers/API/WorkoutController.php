<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workouts = Workout :: all();
        return response()->json($workouts);
        
    }



    public function store(Request $request)
    {
        if (!in_array($user->role, ['trainer', 'admin'])) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to add a new workout'
            ], 403);
        }
    
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Create a new Workout record
        $workout = Workout::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
        ]);
    
        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Workout created successfully',
            'data' => $workout
        ], 201);
    }

    



    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
