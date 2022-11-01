<?php

namespace App\Http\Controllers;

use App\SubTaskModel;
use Exception;
use Illuminate\Http\Request;

class SubTController extends Controller
{
    public function add(Request $request)
    {
        try {
            $title = trim($request->input('sub_title'));
            $params = [
                'task_id' => $request->id,
                'sub_title' => $title,
                'status' => '0',
                'status_title'=>"pending",
                'is_deleted' =>'0',
            ];
            $subtask_id = SubTaskModel::insertGetId($params);
            $message['id'] = $subtask_id;
            $message['title']=$title;
            $message['message'] = 'SubTask Added Sucessfully';

            return response()->json($message);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_sub_task(Request $request)
    {
        try {
            $id = $request->id;
            $data = SubTaskModel::find($id);
            if($data) {
    
                $data->status = $request->status;
                if($data->status==1){
                    $data->status_title="completed";
                }else
                {
                    $data->status_title="pending";
                }
                $data->save();

                if($data->save()){
                    $message['id'] = $id;
                    $message['task_status']=$data->status_title;
                    $message['message'] = 'SubTask updated Sucessfully';
                }else
                {
                    $message['error'] = "something went wrong";

                }
              
            }else
            {
                $message['error'] = "data not found";

            }

            return response()->json($message);
            

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete_subTask(Request $request){
        $id = $request->id;
        $data = SubTaskModel::find($id);

        if($data) {
            $data->is_deleted=1;
            $data->save();
            if($data->save()){
                $message['id'] = $id;
                $message['message'] = 'Task deleted Sucessfully';
            }else
            {
                $message['error'] = "something went wrong";

            }
        }else
        {
            $message['error'] = "data not foun";
        }
        return response()->json($message);

    }
}
