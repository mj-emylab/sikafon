<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Payment
 * @package App\Models
 * @version June 21, 2024, 4:19 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\User $user1
 * @property \App\Models\User $user2
 * @property \App\Models\AccountUser $accountUser
 * @property \App\Models\AccountUser $accountUser3
 * @property \App\Models\Code $code
 * @property \App\Models\Code $code4
 * @property integer $user_id
 * @property integer $from_id
 * @property integer $to_id
 * @property integer $account_from_id
 * @property integer $account_to_id
 * @property integer $code_id
 * @property integer $qrcode_id
 * @property string $uuid
 * @property string $amount
 * @property string $about
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class Payment extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payments';


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
        'from_id',
        'to_id',
        'account_from_id',
        'account_to_id',
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
        'from_id' => 'integer',
        'to_id' => 'integer',
        'account_from_id' => 'integer',
        'account_to_id' => 'integer',
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
    public function user1()
    {
        return $this->hasOne(\App\Models\User::class, 'from_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user2()
    {
        return $this->hasOne(\App\Models\User::class, 'to_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function accountUser()
    {
        return $this->hasOne(\App\Models\AccountUser::class, 'account_from_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function accountUser3()
    {
        return $this->hasOne(\App\Models\AccountUser::class, 'account_to_id', 'id');
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
    public function code4()
    {
        return $this->hasOne(\App\Models\Code::class, 'qrcode_id', 'id');
    }
}
