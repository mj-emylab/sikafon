<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class AppPlan
 * @package App\Models
 * @version June 21, 2024, 4:44 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Code $code
 * @property \App\Models\Code $code1
 * @property integer $user_id
 * @property integer $code_id
 * @property integer $qrcode_id
 * @property string $uuid
 * @property string $amount
 * @property string $about
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class AppPlan extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'app_plans';


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
        'code_id',
        'qrcode_id',
        'uuid',
        'amount',
        'about',
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
        'code_id' => 'integer',
        'qrcode_id' => 'integer',
        'uuid' => 'string',
        'amount' => 'string',
        'about' => 'string',
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
    public function code()
    {
        return $this->hasOne(\App\Models\Code::class, 'code_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function code1()
    {
        return $this->hasOne(\App\Models\Code::class, 'qrcode_id', 'id');
    }
}
