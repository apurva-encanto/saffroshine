<?php

namespace App\Http\Controllers\Api;

use DB;

use Validator;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class LabController extends BaseController
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




    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'lab_name' => 'required|unique:labs',
            'parent_lab' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }
        try {
            $labs=new Lab();
            $labs->lab_name=$request->lab_name;
            $labs->parent_lab = $request->parent_lab;
            $labs->members = 0;
            $labs->status = 1;
            $labs->save();
            return $this->sendResponse($labs, 'Lab saved successfully.');


        } catch (\Exception $e) {
            return $this->sendError('An error occurred while saving the lab.', []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateLabs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lab_name' => ['required', Rule::unique('labs')->ignore($id)],
            'parent_lab' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $lab=Lab::find($id);
        if($lab)
        {
            if($lab->parent_lab !=0)
            {
                $lab->lab_name=$request->lab_name;
                $lab->status = $request->status;
                $lab->parent_lab = $request->parent_lab;
                $lab->save();
                return $this->sendResponse([], 'Lab updated successfully.');


            }else{
              return $this->sendError('Can Update the Main Lab', []);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
       $lab=Lab::find($id);
       $lab->delete();
        return $this->sendResponse([], ' Labs deleted successfully.');
        //
    }

    public function mainLabs()
    {
       $labs= Lab::where('parent_lab',0)->get();
       if($labs)
       {
            return $this->sendResponse($labs, 'Main Labs get successfully.');
       }

    }
    public function mainLabsDeatils($id)
    {
        $mainLab= Lab::where(['id'=> $id, 'parent_lab'=>0])->first();
        if($mainLab)
        {
            if ($mainLab->status == 1) {
                $labs = Lab::select('labs.id', 'labs.lab_name', DB::raw('COUNT(users.id) AS members_count'))
                ->leftJoin('users', 'labs.id', '=', 'users.lab_id')
                ->where('labs.parent_lab', $id)
                ->groupBy('labs.id', 'labs.lab_name')
                ->get();

                if ($labs) {
                    return $this->sendResponse($labs, 'Main Labs get successfully.');
                }
            } else {
                return $this->sendResponse([], 'Main Labs is Inactive.');
            }

        }else{
            return $this->sendError('Lab Not Exists', []);
        }



    }

    public function mainLabsById($id)
    {
        $labs = Lab::find($id);
        if ($labs) {
            $membersCount = $labs->membersCount;
            $data = ['lab' => $labs, 'count' => $membersCount];
            return $this->sendResponse($data, 'Main Labs get successfully.');
        }
    }

    public function department_create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lab_name' => 'required|unique:labs',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        try {
            $labs = new Lab();
            $labs->lab_name = $request->lab_name;
            $labs->parent_lab = 0;
            $labs->members = 0;
            $labs->status = 1;
            $labs->save();
            return $this->sendResponse($labs, 'Department saved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('An error occurred while saving the lab.', []);
        }

    }
    public function lab_status($id)
    {
        $lab = Lab::find($id);
        if ($lab) {
            $status = ($lab->status == 1) ? 0 : 1;
            $lab->status= $status;
            $lab->save();

            return $this->sendResponse([], 'Lab Status Change successfully.');

        }
        else {
            return $this->sendError('Lab Not Exists', []);
        }

    }

    public function department_update(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'lab_name' =>[ 'required', Rule::unique('labs')->ignore($id)],
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $lab = Lab::find($id);
        if ($lab) {

            $lab->lab_name = $request->lab_name;
            $lab->status = $request->status;
            $lab->parent_lab = 0;
            $lab->save();
            return $this->sendResponse([], 'Department updated successfully.');

        } else {
            return $this->sendError('Lab Not Exists', []);
        }

    }

    public function lab_user($id)
    {
        $lab=Lab::find($id);
        if($lab)
        {
           $users= User::where('lab_id',$id)->get();
           return $this->sendResponse($users, 'Users get successfully.');
        }else{
            return $this->sendError('Lab Not Exists', []);

        }

    }
}
