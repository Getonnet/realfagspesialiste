<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $education_area_id
 * @property integer $user_id
 * @property string $dob
 * @property string $contact
 * @property string $address
 * @property string $zip
 * @property string $city
 * @property string $gender
 * @property float $grade
 * @property float $working_hour
 * @property string $description
 * @property string $cv
 * @property string $diploma
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property EducationArea $educationArea
 * @property User $user
 */
class TeacherProfile extends Model
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
    protected $fillable = ['education_area_id', 'user_id', 'dob', 'contact', 'address', 'zip', 'city', 'gender', 'grade', 'working_hour', 'description', 'cv', 'diploma', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function educationArea()
    {
        return $this->belongsTo('App\Models\EducationArea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
