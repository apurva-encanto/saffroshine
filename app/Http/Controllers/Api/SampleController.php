<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Lab;
use App\Models\User;
use App\Models\Sample;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SampleController extends BaseController
{
    public function send_sample(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'raw_material' => 'required',
            'quantity' => 'required',
            'wax_batch_no' => 'required',
            'wax_grade_no' => 'required',
            'date' => 'required',
            'lab_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $lab=Lab::find($request->lab_id);
        if($lab)
        {
            if($lab->parent_lab==1)
            {

                try {
                $sample=new Sample();
                $sample->raw_material = $request->raw_material;
                $sample->quantity = $request->quantity;
                $sample->wax_batch_no = $request->wax_batch_no;
                $sample->wax_grade_no = $request->wax_grade_no;
                $sample->date = $request->date;
                $sample->assign_for=1;
                $sample->lab_id = $request->lab_id;                
                $sample->approved = 0;
                $sample->is_edit = 0;
                $sample->status = 0;
                $sample->save();

                $notification=new Notification();
                $notification->title='Batch '. $sample->id;
                $notification->content = 'New Sample';
                $notification->lab_id=1;
                $notification->save();

                return $this->sendResponse($sample, 'Successfully Sent Lab Samples In '. $lab->lab_name);
                } catch (\Exception $e) {
                    return $this->sendError('An error occurred while sending the Sample.', []);
                }

            }else{
                return $this->sendError('Report Only Send to Lab 1', []);
            }       

        }else{
            return $this->sendError('Lab Not Exists', []);

        }

    }

    public function user_notification($id)
    {
        $user=User::find($id);
        if($user)
        {
            echo $user->parent_lab;


        }else{
            return $this->sendError('User Not Exists', []);

        }
        
    }
}
