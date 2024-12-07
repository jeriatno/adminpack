<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'roles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
     protected $guarded = ['id'];
//    protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    const ADMINISTRATOR = 'admin';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function permissions()
    {
        return $this->hasMany(RoleHasPermission::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_roles', 'role_id', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
