<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $subject_id
 * @property integer $student_id
 * @property integer $teacher_id
 * @property string $start_time
 * @property string $end_time
 * @property float $hour_spend
 * @property string $subject_name
 * @property string $student_name
 * @property string $student_email
 * @property string $teacher_name
 * @property string $teacher_email
 * @property string $description
 * @property string $summery
 * @property boolean $motivational
 * @property boolean $understanding
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $student
 * @property Subject $subject
 * @property User $teacher
 * @property StudyMaterial[] $studyMaterials
 */
class TimeLog extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['subject_id', 'student_id', 'teacher_id', 'start_time', 'end_time', 'hour_spend', 'subject_name', 'student_name', 'student_email', 'teacher_name', 'teacher_email', 'description', 'summery', 'motivational', 'understanding', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studyMaterials()
    {
        return $this->hasMany('App\Models\StudyMaterial');
    }
}
