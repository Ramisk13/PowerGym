<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance :: all();
        return response()->json($attendances);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }


        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:users,id', 
            'workout_id' => 'required|integer|exists:workouts,id', 
            'attended_at' => 'required|date_format:Y-m-d H:i:s',
        ]);
    
       
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); 
        }


        $new_attendance = Attendance :: create ($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'A new attendance is added successfully',
            'data'=> $new_attendance

        ]);
    }

 
    public function update(Request $request, string $id)
    {


        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }


        $attendance = Attendance::find($id);

        
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

       
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:users,id',
            'workout_id' => 'required|integer|exists:workouts,id',
            'attended_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $attendance->update($request->only(['member_id', 'workout_id', 'attended_at']));

       
        return response()->json([
            'status'=>true,
            'message' => 'Attendance record updated successfully',
            'attendance' => $attendance], 200);
    }
    

    public function destroy(string $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'trainer'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Only admin and trainer can access this section.'
            ], 403);
        }

        
        $attendance = Attendance::find($id);

       
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

       
        $attendance->delete();

        
        return response()->json([
            'status' => true,
            'message' => 'Attendance record deleted successfully'
        ], 200);
    }
}
