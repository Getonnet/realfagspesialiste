<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $time_log_id
 * @property string $file_name
 * @property string $description
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property TimeLog $timeLog
 */
class StudyMaterial extends Model
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
    protected $fillable = ['time_log_id', 'file_name', 'description', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeLog()
    {
        return $this->belongsTo('App\Models\TimeLog');
    }
}
