<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\User;

class WorkoutController extends Controller
{
    
    public function index()
    {
        $workouts = Workout :: all();
        return response()->json($workouts);
        
    }



    public function store(Request $request)
    {

        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
      
        $workout = Workout::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Workout created successfully',
            'data' => $workout
        ], 201);
    }

    



    public function update(Request $request, string $id)
    {
       
        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'duration' => 'sometimes|required', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        
        $workout = Workout::find($id);
    
        if (!$workout) {
            return response()->json([
                'status' => false,
                'message' => 'Workout not found'
            ], 404);
        }
    
        
        $workout->update($request->only(['name', 'description', 'duration']));
    
        
        return response()->json([
            'status' => true,
            'message' => 'Workout updated successfully',
            'data' => $workout
        ], 200);

    }




    
    public function destroy(string $id)
    {

        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }
       
        $workout = Workout::find($id);
    
        if (!$workout) {
            return response()->json([
                'status' => false,
                'message' => 'Workout not found'
            ], 404);
        }
    
        
        $workout->delete();
    
       
        return response()->json([
            'status' => true,
            'message' => 'Workout deleted successfully'
        ], 200);
    }
}
