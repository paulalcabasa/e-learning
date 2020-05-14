<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Classification;
use Auth;

class ClassificationController extends Controller
{
    public function store(Request $request){
        $classifications = $request->classifications;
        $category_id = $request->category_id;
        foreach($classifications as $row){
            if($row['deleted_flag'] == 'N'){
                $classification = Classification::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'category_id' => $category_id,
                        'classification' => $row['classification'],
                        'created_by' => session('employee_id')
                    ]
                );
            }
            else {
                Classification::where('id', $row['id'])->delete();
            }
        }
    }

    public function show(Request $request){
        $classifications =  Classification::where('category_id', $request->category_id)->get();
        $data = [];

        foreach($classifications as $row){
            array_push($data,[
                'id' => $row['id'],
                'classification' => $row['classification'],
                'deleted_flag' => 'N'
            ]);
        }

        return $data;
    }
}
