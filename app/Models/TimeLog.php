<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property integer $subject_id
 * @property integer $student_id
 * @property integer $teacher_id
 * @property string $event_start
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
 * @property string $status
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
    protected $fillable = ['subject_id', 'student_id', 'teacher_id', 'event_start', 'start_time', 'end_time', 'hour_spend', 'subject_name', 'student_name', 'student_email', 'teacher_name', 'teacher_email', 'description', 'summery', 'motivational', 'understanding', 'status', 'deleted_at', 'created_at', 'updated_at'];

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

    public function cal_start_before(){
        $today = date('Y-m-d H:i:s');
        $event_day = $this->event_start;
        $startTime = Carbon::parse($today);
        $finishTime = Carbon::parse($event_day);
        $totalDuration = $finishTime->diffInMinutes($startTime, false);
        return $totalDuration;
    }

    public function spend_time($format = 'M'){ //M = Minutes format, H = Hour format
        $startTime = Carbon::parse($this->start_time);
        $finishTime = Carbon::parse($this->end_time);
        $totalDuration = $startTime->diffInMinutes($finishTime, false);
        if (isset($this->end_time)){
            if($format == 'M'){
                return $totalDuration;
            }else{
                return number_format(($totalDuration / 60), 2, '.', ' ');
            }
        }
        return 0;
    }
}
