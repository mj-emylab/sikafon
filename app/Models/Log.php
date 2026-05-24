<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Log
 * @package App\Models
 * @version June 22, 2024, 3:10 am UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\App $app
 * @property integer $user_id
 * @property integer $app_id
 * @property string $uuid
 * @property string $logable_type
 * @property integer $logable_id
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class Log extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'logs';


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
        'app_id',
        'uuid',
        'about',
        'logable_type',
        'logable_id',
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
        'app_id' => 'integer',
        'uuid' => 'string',
        'about' => 'string',
        'logable_type' => 'string',
        'logable_id' => 'integer',
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
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function app()
    {
        return $this->belongsTo(\App\Models\App::class, 'app_id');
    }


    public function logable()
    {
        return $this->morphTo();
    }
}
