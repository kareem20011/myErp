<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit',
        'barcode',
        'quantity',
        'threshold',
        'status',
        'subcategory_id',
        'supplier_id',
        'supplier_id',
        'tenant_id',
        'created_by',
        'updated_by',
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function lowStockNotifications()
    {
        return $this->hasMany(LowStockNotification::class);
    }
}
