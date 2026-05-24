<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Class Flag
 * @package App\Models
 * @version June 21, 2024, 4:18 pm UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $uuid
 * @property string $name
 * @property string $display_name
 * @property string $value
 * @property integer $type
 * @property string $description
 * @property integer $status
 * @property boolean $is_active
 */
class Flag extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'flags';


    const APIACCOUNT = 1919; //
    const ApiEndPoint = "https://xpresspoint.ecobank.com/agencybanking/services/thirdpartyagencybanking/";


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
        'name',
        'display_name',
        'value',
        'type',
        'description',
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
        'name' => 'string',
        'display_name' => 'string',
        'value' => 'string',
        'type' => 'integer',
        'description' => 'string',
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
}
