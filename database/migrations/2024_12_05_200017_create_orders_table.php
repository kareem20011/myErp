<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('order_date')->useCurrent();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['cancelled', 'completed'])->default('completed');
            $table->string('return_reason')->nullable();
            $table->enum('payment_method', ['cash', 'visa']);
            $table->decimal('offer', 10, 2)->nullable();

            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
