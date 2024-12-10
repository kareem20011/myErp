<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tenant_id',
        'created_by',
        'updated_by',
    ];

    // Define the relationship to the User model
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    // Define the relationship to the Permission_roles model
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_id', 'permission_id');
    }
}
