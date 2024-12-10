<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function mainCategories()
    {
        $mainCategories = Category::where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->get();;
        return view('pos.products.mainCategories', compact('mainCategories'));
    }

    public function subCategories($id)
    {
        $mainCategory = Category::with('subcategories')->where(['id' => $id, 'tenant_id' => session('tenant_id')])->first();
        return view('pos.products.subCategories', compact('mainCategory'));
    }

    public function products($id)
    {
        $subCategory = Subcategory::with([
            'category', // لتحميل العلاقة مع الفئة (category)
            'products' => function ($query) { // لتحميل المنتجات النشطة فقط
                $query->where('status', 'active')
                    ->orderBy('name', 'asc'); // ترتيب المنتجات أبجديًا حسب اسم المنتج
            }
        ])->where([
            'id' => $id,
            'tenant_id' => session('tenant_id')
        ])->first();

        return view('pos.products.products', compact('subCategory'));
    }
}
