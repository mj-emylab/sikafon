<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class RequestLog
 * @package App\Models
 * @version July 21, 2024, 9:32 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\App $app
 * @property integer $user_id
 * @property integer $app_id
 * @property string $uuid
 * @property string $request_status
 * @property string $request_id
 * @property string $payload
 * @property string $response
 * @property string $logable_type
 * @property integer $logable_id
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class RequestLog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'request_logs';
    

    protected $dates = ['deleted_at'];


    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }



    public $fillable = [
        'user_id',
        'app_id',
        'uuid',
        'request_status',
        'request_id',
        'payload',
        'response',
        'error_message',
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
        'request_status' => 'string',
        'request_id' => 'string',
        'payload' => 'string',
        'response' => 'string',
        'error_message' => 'string',
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
        return $this->hasOne(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function app()
    {
        return $this->hasOne(\App\Models\App::class, 'app_id', 'id');
    }
}
