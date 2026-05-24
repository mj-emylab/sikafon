<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 * @package App\Models
 * @version August 20, 2023, 12:00 pm UTC
 *
 * @property string $uuid
 * @property string $findme_id
 * @property string $findme_id
 * @property string $findme_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property integer $user_type
 * @property boolean $remember_me
 * @property boolean $is_active
 */
class User extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'users';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'uuid',
        'findme_id',
        'name',
        'email',
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
        'findme_id' => 'string',
        'name' => 'string',
        'email' => 'string',
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
    public static function rules($id=null){
            return [
               'uuid' => 'required',
        'findme_id' => 'required'
            ];
    }



    
}
