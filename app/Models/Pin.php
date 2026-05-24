<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Pin
 * @package App\Models
 * @version June 21, 2024, 4:20 pm UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $uuid
 * @property string $msg
 * @property string $code
 * @property string $codeable_type
 * @property integer $codeable_id
 * @property string $expired_at
 * @property integer $type
 * @property integer $status
 * @property integer $right
 * @property boolean $is_active
 */
class Pin extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'pins';


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
        'msg',
        'code',
        'codeable_type',
        'codeable_id',
        'expired_at',
        'type',
        'status',
        'right',
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
        'msg' => 'string',
        'code' => 'string',
        'codeable_type' => 'string',
        'codeable_id' => 'integer',
        'expired_at' => 'string',
        'type' => 'integer',
        'status' => 'integer',
        'right' => 'integer',
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

    public function pinable()
    {
        return $this->morphTo();
    }

}
