<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowStockNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'status',
        'resolved_at',
        'resolved_by',
        'tenant_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
