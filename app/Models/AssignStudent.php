<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignStudent extends Model
{

    protected $keyType = 'integer';

    protected $fillable = ['student_id', 'teacher_id', 'deleted_at', 'created_at', 'updated_at'];

    public function students()
    {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    public function teachers()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }
}
