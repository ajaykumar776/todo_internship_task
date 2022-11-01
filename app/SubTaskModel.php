<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTaskModel extends Model
{
    protected  $table  = "sub_task";
    public $timestamps = false;

    public function Tasks()
    {
        return $this->belongsTo(TaskModel::class);
    }

}
