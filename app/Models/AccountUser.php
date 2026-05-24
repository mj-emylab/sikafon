<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class AccountUser
 * @package App\Models
 * @version June 21, 2024, 4:14 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Account $account
 * @property \App\Models\Code $code
 * @property \App\Models\Code $code1
 * @property integer $user_id
 * @property integer $account_id
 * @property integer $code_id
 * @property integer $qrcode_id
 * @property string $uuid
 * @property string $name
 * @property string $about
 * @property integer $type
 * @property string $balance
 * @property integer $status
 * @property boolean $is_active
 */
class AccountUser extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'account_users';


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
        'account_id',
        'code_id',
        'qrcode_id',
        'uuid',
        'name',
        'account_no',
        'account_ref',
        'agent_code',
        'about',
        'phone',
        'type',
        'balance',
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
        'account_id' => 'integer',
        'code_id' => 'integer',
        'qrcode_id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'account_no' => 'string',
        'account_ref' => 'string',
        'agent_code' => 'string',
        'about' => 'string',
        'type' => 'integer',
        'balance' => 'string',
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
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function code()
    {
        return $this->belongsTo(\App\Models\Code::class, 'code_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function code1()
    {
        return $this->hasOne(\App\Models\Code::class, 'qrcode_id', 'id');
    }
}
