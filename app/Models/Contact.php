<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Contact
 * @package App\Models
 * @version June 21, 2024, 4:16 pm UTC
 *
 * @property string $uuid
 * @property string $name
 * @property string $subject
 * @property string $email
 * @property string $msg
 * @property integer $status
 * @property boolean $is_active
 */
class Contact extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'contacts';


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
        'name',
        'subject',
        'email',
        'msg',
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
        'name' => 'string',
        'subject' => 'string',
        'email' => 'string',
        'msg' => 'string',
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
