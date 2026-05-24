<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Bin
 * @package App\Models
 * @version June 21, 2024, 4:15 pm UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $uuid
 * @property string $binable_type
 * @property integer $binable_id
 * @property integer $duration_value
 * @property string $duration
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class Bin extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'bins';


    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'uuid',
        'binable_type',
        'binable_id',
        'duration_value',
        'duration',
        'type',
        'status',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'uuid' => 'string',
        'binable_type' => 'string',
        'binable_id' => 'integer',
        'duration_value' => 'integer',
        'duration' => 'string',
        'type' => 'integer',
        'status' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
    * @param null $id
    * @return array
    */
    public static $rules = [
        'uuid' => 'nullable'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'user_id', 'id');
    }
}
