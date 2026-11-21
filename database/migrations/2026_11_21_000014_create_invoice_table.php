<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Invoice', function (Blueprint $table) {
            $table->increments('InvoiceId');
            $table->unsignedInteger('ApartmentId');
            $table->char('BillingPeriod', 7);
            $table->decimal('TotalAmount', 18, 2)->default(0);
            $table->date('DueDate');
            $table->string('Status', 20)->default('UNPAID');
            $table->string('PaymentType', 20)->nullable();
            $table->timestamp('PaidAt')->nullable();
            $table->unsignedInteger('CreatedByUserId');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();

            $table->unique(['ApartmentId', 'BillingPeriod'], 'UQ_Invoice_Apartment_BillingPeriod');
            $table->index('CreatedByUserId', 'IX_Invoice_CreatedByUserId');
            $table->index(['Status', 'DueDate'], 'IX_Invoice_Status_DueDate');

            $table->foreign('ApartmentId', 'FK_Invoice_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('CreatedByUserId', 'FK_Invoice_CreatedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Invoice');
    }
};
