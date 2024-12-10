<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'status',
        'notes',
        'tenant_id',
        'created_by',
        'updated_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
