<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

use App\Models\AppPlanUser;
use Carbon\Carbon;

/**
 * Class User
 * @package App\Models
 * @version June 21, 2024, 4:06 pm UTC
 *
 * @property string $uuid
 * @property string $gh_card_id
 * @property string $code
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $dob
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property string $password
 * @property integer $status
 * @property integer $user_type
 * @property boolean $remember_me
 * @property boolean $is_active
 */
class User extends Authenticatable
{
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'users';
    

    protected $dates = ['deleted_at'];

    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }



    public $fillable = [
        'uuid',
        'card_id',
        'card_type',
        'code',
        'code_url',
        'first_name',
        'last_name',
        'middle_name',
        'dob',
        'email',
        'image',
        'sex',
        'phone',
        'address',
        'password',
        'status',
        'user_type',
        'remember_me',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'card_id' => 'string',
        'card_type' => 'string',
        'code' => 'string',
        'code_url' => 'string',
        'image' => 'string',

        'sex' => 'string',

        'first_name' => 'string',
        'last_name' => 'string',
        'middle_name' => 'string',
        'dob' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'password' => 'string',
        'status' => 'integer',
        'user_type' => 'integer',
        'remember_me' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
    * @param null $id
    * @return array
    */
    public static $rules = [
        'uuid' => 'nullable',
        'email' => 'required|email|unique:users',
    ];




    // public function card()
    // {
    //     return $this->hasOne(\App\Models\CardUser::class, 'user_id', 'id')->with('card');
    // }

    public function accounts()
    {
        return $this->hasMany(\App\Models\AccountUser::class, 'user_id')->with('account');
    }

    public function apps()
    {
        return $this->hasMany(\App\Models\App::class, 'user_id')->with('account');
    }

    public function pins()
    {
        return $this->morphMany(\App\Models\Pin::class, 'pinable')->with('user');
    }




    public function getHasActiveAppAttribute()
    {
        $nowDate = Carbon::now();
        $check = AppPlanUser::where('user_id', $this->user_id)
            ->where('end_at', '>', $nowDate)
            ->where('status', 5)
            ->first();

        if(!empty($check)) {
            return true;
        }
        return false;
        
    }



    
}
