<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;

class MembershipController extends Controller
{
    
    public function index()
    {
        $membership = Membership :: all();
        return response()->json($membership);
    }




   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_in_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); 
        }

       
        $membership = Membership::create($request->all());

        
        return response()->json([
            'status' => true,
            'message' => 'Membership created successfully',
            'data' => $membership
        ], 201); 
    }

   
    public function update(Request $request, string $id)
    {
        $membership = Membership::find($id);

        
        if (!$membership) {
            return response()->json([
                'status' => false,
                'message' => 'Membership not found'
            ], 404);
        }

        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'required|string',
            'duration_in_months' => 'sometimes|required|integer|min:1', 
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); 
        }

       
        $membership->update($request->only(['name', 'description', 'duration_in_months', 'price']));

        
        return response()->json([
            'status' => true,
            'message' => 'Membership updated successfully',
            'data' => $membership
        ], 200); 
    }

    




    public function destroy(string $id)
    {
        $membership = Membership::find($id);

        
        if (!$membership) {
            return response()->json([
                'status' => false,
                'message' => 'Membership not found'
            ], 404);
        }

        $membership->delete();

        return response()->json([
            'status'=> true,
            'message'=>'Membership deleted succesfully'
        ]);
    }
}
