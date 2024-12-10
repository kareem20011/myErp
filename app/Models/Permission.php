<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group',
        'tenant_id',
        'created_by',
        'updated_by',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles', 'permission_id', 'role_id');
    }
}
