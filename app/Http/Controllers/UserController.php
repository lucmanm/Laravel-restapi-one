<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // Return Json Response
        return response()->json(['results' => $users], 200);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            //Create User
            User::Create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return response()->json([
                'message' => "User Successfully created."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went wrong!"
            ], 500);
        }
    }

    public function show($id)
    {
        $users = User::find($id);
        //User Details
        if (!$users) {
            return response()->json([
                'message' => "User Not Found."
            ], 404);
        }
        // Return Json Response
        return response()->json([
            'users' => $users
        ], 200);
    }
    public function update(UserStoreRequest $request, $id)
    {
        try {
            //find User
            $users = User::find($id);
            if (!$users) {
                return response()->json([
                    'message' => "User Not Found."
                ], 404);
            }
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = $request->password;

            // Update User
            $users->save();

            // Return Json Response
            return response()->json([
                'message' => "Updated Successfully."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went wrong!"
            ], 500);
        }
    }
    public function destroy($id)
    {
        //Look for info
        $users = User::find($id);
        if (!$users) {
            return response()->json([
                'message' => "User Not Found."
            ], 404);
        }

        //Delete User
        $users->delete();

        //Return JSON Response
        return response()->json([
            'message' => "User Successfully Deleted."
        ], 200);
    }
}
