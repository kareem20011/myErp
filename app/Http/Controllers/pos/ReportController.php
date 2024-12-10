<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index()
    {
        return view('pos.reports.index');
    }


    public function SalesReport(Request $request)
    {
        $type = $request->input('type', 'daily'); // افتراضيًا "يومي"
        $year = $request->input('year', now()->year); // السنة الحالية
        $status = $request->input('status'); // الحالة قد تكون فارغة
        $tenantId = session('tenant_id'); // التحقق من وجود tenant_id

        // التحقق من وجود tenant_id
        if (!$tenantId) {
            return redirect()->back()->with('error', 'Tenant ID is required.'); // يمكن استبدال هذا برسالة خطأ أو استجابة مخصصة
        }

        $orders = Order::query();

        // تطبيق الفلاتر بناءً على النوع
        $orders->when($type === 'daily', fn($q) => $q->whereDate('order_date', today()))
            ->when($type === 'weekly', fn($q) => $q->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($type === 'monthly', fn($q) => $q->whereMonth('order_date', now()->month)->whereYear('order_date', now()->year))
            ->when($type === 'yearly' && $year, fn($q) => $q->whereYear('order_date', $year));

        // تطبيق التصفية على الحالة إذا كانت موجودة
        if (!empty($status)) {
            $orders->where('status', $status);
        }

        // تصفية بناءً على tenant_id
        $orders->where('tenant_id', $tenantId);

        // جلب البيانات مع العميل
        $reportData = $orders->with('customer')->get();

        // إرجاع العرض
        return view('pos.reports.includes.sales.content', compact('reportData'));
    }









    public function topSellingProducts(Request $request)
    {
        // تحديد التواريخ من الفلاتر
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());

        $startDate = Carbon::parse($startDate)->startOfDay();  // بداية اليوم
        $endDate = Carbon::parse($endDate)->endOfDay();  // نهاية اليوم


        // استعلام للحصول على أكثر المنتجات مبيعًا
        $topSellingProducts = Order::select(
            'products.name',
            'products.price',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.quantity * products.price) as total_sales_amount') // إجمالي المبلغ من المنتجات المباعة
        )
            ->where('orders.tenant_id', session('tenant_id')) // التحقق من tenant_id في الجلسة بالنسبة للطلبات
            ->where('products.tenant_id', session('tenant_id')) // التحقق من tenant_id في الجلسة بالنسبة للمنتجات
            ->where('orders.status', '!=', 'cancelled') // استبعاد الطلبات الملغاة
            ->whereBetween('orders.order_date', [$startDate, $endDate]) // الفلاتر حسب التاريخ
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_quantity') // ترتيب حسب الكمية المباعة
            ->get();





        // إرجاع البيانات كـ JSON (للـ Ajax)
        return response()->json(['topSellingProducts' => $topSellingProducts]);
    }









    public function topCustomers(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());

        $topCustomers = Order::select(
            'customers.name',
            'customers.email',
            DB::raw('COUNT(orders.id) as total_orders'), // إجمالي عدد الطلبات
            DB::raw('SUM(orders.total_amount) as total_spent') // إجمالي المبلغ المصروف
        )
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.tenant_id', session('tenant_id')) // فلتر المستأجر
            ->where('orders.status', '!=', 'cancelled') // استبعاد الطلبات الملغاة
            ->whereBetween('orders.order_date', [$startDate, $endDate]) // تحديد نطاق التاريخ
            ->groupBy('customers.id', 'customers.name', 'customers.email')
            ->orderByDesc('total_spent') // ترتيب حسب إجمالي المبلغ المصروف
            ->get();


        return response()->json(['topCustomers' => $topCustomers]);
    }
}
