<?php

namespace App\Http\Controllers\Api;

use Hash;
use Validator;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone_no' => 'required',
            'parent_lab' => 'required',
            'lab_id' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $labExists=Lab::where(['id'=> $request->lab_id,'parent_lab'=>$request->parent_lab])->first();
        if($labExists)
        {
            try {
            $user=new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->phone_no = $request->phone_no;
            $user->password= Hash::make($request->password);
            $user->parent_lab=$request->parent_lab;
            $user->lab_id=$request->lab_id;
            $user->role=0;
            $user->device_token = $request->device_token ? $request->device_token : '';                
            $user->save();
            return $this->sendResponse($user, 'User Created successfully.');
            } catch (\Exception $e) {
                return $this->sendError('An error occurred while saving the user.', []);
            }


        }else{
            return $this->sendError('Not a Valid Lab.', []);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required','email', Rule::unique('users')->ignore($id)],
            'phone_no' => 'required',
            'parent_lab' => 'required',
            'lab_id' => 'required',
            'status' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $labExists = Lab::where(['id' => $request->lab_id, 'parent_lab' => $request->parent_lab])->first();
        if ($labExists) {
            $user=User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_no = $request->phone_no;
            if($request->password)
            {
                $user->password = Hash::make($request->password);
            }
            $user->parent_lab = $request->parent_lab;
            $user->lab_id = $request->lab_id;
            $user->role = 0;
            $user->status = $request->status;
            $user->save();

            return $this->sendResponse([], 'User Updated successfully.');

        } else {
            return $this->sendError('Not a Valid Lab.', []);
        }
    }

    public function getUserId($id)
    {
        $userExists = User::where(['id' => $id])->first();
        if ($userExists) {
                       return $this->sendResponse($userExists, 'User get successfully.');

        }else{
            return $this->sendError('User Not Exists.', []);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user=User::find($id);
        $user->delete();
        return $this->sendResponse([], ' User deleted successfully.');
    }

    public function profile_upload(Request $request, string $id)
    {

        $user = User::find($id);
        if($user)
        {
            if ($request->name) {
            $user->name = $request->name;
            }
 
            if($request->file('profile_img'))
            {
                // Get the uploaded file
                $image = $request->file('profile_img');
                $directory = public_path('uploads');
                // Create the directory if it doesn't exist
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $newFileName = 'user_' . time() . '.' . $image->getClientOriginalExtension();
                // Move the uploaded file to the specified directory
                $image->move($directory, $newFileName);

                $user->profile_img=$newFileName;
            }

            $user->save();
            return $this->sendResponse([], ' Profile updated successfully.');


        }else{
            return $this->sendError('User Not Exists.', []);

        }



    }
}
