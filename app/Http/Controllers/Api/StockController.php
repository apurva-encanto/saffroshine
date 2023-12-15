<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends BaseController
{
    public function index()
    {
        $stock=Stock::all();
        return $this->sendResponse($stock, 'Samples get successfully.');


    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'raw_material' => 'required',
            'quantity' => 'required',
            'wax_batch_no' => 'required',
            'wax_grade_no' => 'required',
            'date' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }
        try {

        $stock=new Stock();
        $stock->raw_material=$request->raw_material;
        $stock->quantity=$request->quantity;
        $stock->wax_batch_no=$request->wax_batch_no;
        $stock->wax_grade_no=$request->wax_grade_no;
        $stock->date=$request->date;
        $stock->status = 1;
        $stock->save();

        return $this->sendResponse($stock, 'Stock Created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('An error occurred while saving the Stock.', []);
        }

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'raw_material' => 'required',
            'quantity' => 'required',
            'wax_batch_no' => 'required',
            'wax_grade_no' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);
        }

        $stock=Stock::find($id);
        if($stock)
        {
            $stock->raw_material = $request->raw_material;
            $stock->quantity = $request->quantity;
            $stock->wax_batch_no = $request->wax_batch_no;
            $stock->wax_grade_no = $request->wax_grade_no;
            $stock->date = $request->date;
            $stock->status = $request->status;
            $stock->save();

            return $this->sendResponse($stock, 'Stock updated successfully.');
        }else{
            return $this->sendError('Stock Not Exists', []);

        }
    }

    public function delete($id)
    {
        $stock=Stock::find($id);
        if($stock)
        {
            $stock->delete();
            return $this->sendResponse($stock, 'Stock deleted successfully.');

        }else{
            return $this->sendError('Stock Not Exists', []);

        }
    }

    public function edit($id)
    {
        $stock = Stock::find($id);
        if ($stock) {
            return $this->sendResponse($stock, 'Stock get successfully.');
        } else {
            return $this->sendError('Stock Not Exists', []);
        }
    }
}
