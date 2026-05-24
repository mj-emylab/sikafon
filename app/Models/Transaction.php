<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Transaction
 * @package App\Models
 * @version June 21, 2024, 4:22 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Payment $payment
 * @property integer $user_id
 * @property string $uuid
 * @property integer $payment_id
 * @property string $amount
 * @property string $code
 * @property string $session_code
 * @property string $transaction_code
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class Transaction extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'transactions';


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
        'payment_id',
        'amount',
        'code',
        'session_code',
        'transaction_code',
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
        'payment_id' => 'integer',
        'amount' => 'string',
        'code' => 'string',
        'session_code' => 'string',
        'transaction_code' => 'string',
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
    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'payment_id', 'id');
    }

    public function log()
    {
        return $this->morphOne(\App\Models\Log::class, 'logable');
    }
    

}
