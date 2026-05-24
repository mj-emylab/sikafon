<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class CardUser
 * @package App\Models
 * @version June 21, 2024, 4:15 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Card $card
 * @property integer $user_id
 * @property integer $card_id
 * @property string $uuid
 * @property string $msg
 * @property string $code
 * @property string $issued_at
 * @property string $expired_at
 * @property integer $type
 * @property integer $status
 * @property integer $right
 * @property boolean $is_active
 */
class CardUser extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'card_users';


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
        'card_id',
        'uuid',
        'msg',
        'code',
        'issued_at',
        'expired_at',

        
        'first_name',
        'last_name',
        'card_no',
        'id_type',
        'live_selfie', 

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
        'card_id' => 'integer',
        'uuid' => 'string',
        'msg' => 'string',
        'code' => 'string',
        'issued_at' => 'string',
        'expired_at' => 'string',

        'first_name' => 'string',
        'last_name' => 'string',
        'card_no' => 'string',
        'id_type' => 'string',
        'live_selfie' => 'string',

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
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function card()
    {
        return $this->hasOne(\App\Models\Card::class, 'card_id', 'id');
    }
}




// ALTER TABLE card_users ADD COLUMN live_selfie varchar(250) AFTER expired_at;
// ALTER TABLE card_users ADD COLUMN last_name varchar(250) AFTER expired_at;
// ALTER TABLE card_users ADD COLUMN first_name varchar(250) AFTER expired_at;
// ALTER TABLE card_users ADD COLUMN card_no varchar(250) AFTER expired_at;
// ALTER TABLE card_users ADD COLUMN id_type varchar(250) AFTER expired_at;