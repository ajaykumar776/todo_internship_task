<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected  $table  = "tasks";
    public $timestamps = false;

    public function subTasks()
    {
        return $this->hasMany(SubTaskModel::class ,'task_id');
    }
}
