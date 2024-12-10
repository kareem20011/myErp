<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLogs extends Model
{
    use HasFactory;

    // Disable Laravel's default timestamps
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'ip_address',
        'device',
        'login_time',
        'logout_time',
    ];
}
