<?php

namespace App\Http\Controllers;

use App\SubTaskModel;
use App\TaskModel;
use Exception;
use Illuminate\Http\Request;

class Tcontroller extends Controller
{
    public function index(){

        $data_list = TaskModel::with('subTasks')->where('is_deleted','!=',1)->get();
        return response()->json($data_list);
    }

    public function add(Request $request)
    {
        try {
            $title = trim($request->input('title'));
            $data = TaskModel::where('title', $title)->where('is_deleted',0)->first();
            if($data){
                $message['error'] = "Dublicate Task Title please use another one ";
            }else
            {
                $due_date = $request->input('due_date');
                $params = [
                    'title' => $title,
                    'due_date' => $due_date,
                    'status' => '0',
                    'status_title'=>"pending",
                    'is_deleted' =>'0',
                ];
                $task_id = TaskModel::insertGetId($params);
                $message['id'] = $task_id;
                $message['title']=$title;
                $message['message'] = 'Task Added Sucessfully';
            }
            return response()->json($message);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function update_task(Request $request)
    {
        try {
            $id = $request->id;
            $data = TaskModel::find($id);
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
                    $message['message'] = 'Task updated Sucessfully';
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

 

    public function delete_Task(Request $request){

        $id = $request->id;
        $subTasks = SubTaskModel::where('task_id', $id)->get();
        foreach($subTasks as $subTask){
            $sub_task = SubTaskModel::find($subTask->id);
            if($sub_task->is_deleted==0){
                $sub_task->is_deleted="1";
                $sub_task->save();
            }
        }
        $task = TaskModel::find($id);
        if($task->is_deleted==0){
            $task->is_deleted="1";
            $task->save();
        }
        if($task->save()){
            $message['task_id'] = $id;
            $message['message'] = 'Task and subtasks deleted Sucessfully';
        }else
        {
            $message['error'] = "something went wrong";

        }
        return response()->json($message);

    }

}
