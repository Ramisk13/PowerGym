<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberMembership;
class MemberMembershipController extends Controller
{
   
    public function index()
    {
        $memberMemberships = MemberMembership :: all();
        return response()->json ($memberMemberships);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'membership_id' => 'required|integer|exists:memberships,id',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $new_memberMembership = MemberMembership :: create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'A new memberMembership is added successfully',
            'data'=> $new_memberMembership

        ]);
    }

 
    public function update(Request $request, string $id)
    {
         $memberMembership = MemberMembership::find($id);

        
        if (!$memberMembership) {
            return response()->json(['message' => 'Member membership record not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'membership_id' => 'required|integer|exists:memberships,id',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the member membership record 
        $memberMembership->update($request->all());

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Member membership record updated successfully',
            'member_membership' => $memberMembership
        ], 200);
    }

    public function destroy(string $id)
    {
        $memberMembership = MemberMembership::find($id);

        if (!$memberMembership) {
            return response()->json(['message' => 'Member membership record not found'], 404);
        }

        $memberMembership->delete();

        return response()->json([
            'status' => true,
            'message' => 'MemberMembership record deleted successfully'
        ], 200);


    }
}
