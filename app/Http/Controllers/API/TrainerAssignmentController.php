<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerAssignment;
use App\Models\User;

class TrainerAssignmentController extends Controller
{
    

    public function index()
    {
        $trainerassignments = TrainerAssignment :: all();
        return response()->json($trainerassignments);
    }

   



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trainer_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    
                    $user = User::find($value);
                    if (!$user || $user->role !== 'trainer') {
                        $fail('The selected trainer is not a valid trainer.');
                    }
                },
            ],
            'workout_id' => 'required|exists:workouts,id', // Adjust based on your actual table
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $trainerAssignment = TrainerAssignment::create([
            'trainer_id' => $request->trainer_id,
            'workout_id' => $request->workout_id,
        ]);

        // Return a success response
        return response()->json([
            'status'=>true,
            'message' => 'Trainer assignment created successfully',
            'data' => $trainerAssignment
        ], 201);

        
    }




    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'trainer_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->role !== 'trainer') {
                        $fail('The selected trainer is not a valid trainer.');
                    }
                },
            ],
            'workout_id' => 'required|exists:workouts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $trainerAssignment = TrainerAssignment::find($id);

    if (!$trainerAssignment) {
        return response()->json([
            'status' => false,
            'message' => 'TrainerAssignment not found'
        ], 404);
    }

    // Update the record with new values
    $trainerAssignment->trainer_id = $request->trainer_id;
    $trainerAssignment->workout_id = $request->workout_id;
    $trainerAssignment->save();

    // Return a success response
    return response()->json([
        'status' => true,
        'message' => 'Trainer assignment updated successfully',
        'data' => $trainerAssignment
    ], 200);
    }




    public function destroy(string $id)
    {
        $trainerAssignment = TrainerAssignment::find($id);

        if (!$trainerAssignment) {
            return response()->json([
                'status' => false,
                'message' => 'TrainerAssignment not found'
            ], 404);
        }

        
        $trainerAssignment->delete();

        
        return response()->json([
            'status' => true,
            'message' => 'Trainer assignment deleted successfully'
        ], 200);
        }
    }

