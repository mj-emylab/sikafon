<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class ResetPassword
 * @package App\Models
 * @version June 21, 2024, 4:20 pm UTC
 *
 * @property string $uuid
 * @property string $email
 * @property string $code
 * @property integer $status
 * @property boolean $is_active
 */
class ResetPassword extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'reset_passwords';


    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'uuid',
        'email',
        'code',
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
        'uuid' => 'string',
        'email' => 'string',
        'code' => 'string',
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



    
}
