<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'day',
        'month',
        'year',
        'role_id',
        'tenant_id',
        'created_by',
        'updated_by',
        'status',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permissionName, $group = null)
    {
        // get all user permissions
        if (auth()->user()->tenant_id != null) {
            $permissions = $this->role->permissions;

            // search by name and group if group exiest
            if ($group) {
                return $permissions->where('name', $permissionName)->where('group', $group)->isNotEmpty();
            }

            // search with name only
            return $permissions->where('name', $permissionName)->isNotEmpty();
        }
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
