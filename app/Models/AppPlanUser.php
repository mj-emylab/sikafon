<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class AppPlanUser
 * @package App\Models
 * @version June 21, 2024, 4:44 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\App $app
 * @property integer $user_id
 * @property integer $app_id
 * @property string $uuid
 * @property string $about
 * @property integer $type
 * @property integer $status
 * @property boolean $is_active
 */
class AppPlanUser extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'app_plan_users';


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
        'app_id',
        'uuid',
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
        'app_id' => 'integer',
        'uuid' => 'string',
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
    public function app()
    {
        return $this->hasOne(\App\Models\App::class, 'app_id', 'id');
    }
}
