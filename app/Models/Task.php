<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','description','project_id','user_id','status','percentage'];

    public function project() 
    { 
        return $this->belongsTo(Project::class); 
    }

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
}
