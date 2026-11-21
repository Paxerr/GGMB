<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('InvoiceItem', function (Blueprint $table) {
            $table->increments('InvoiceItemId');
            $table->unsignedInteger('InvoiceId');
            $table->unsignedInteger('FeeTypeId');
            $table->unsignedInteger('FeeRateId');
            $table->decimal('Quantity', 12, 3);
            $table->decimal('UnitPrice', 18, 2);
            $table->decimal('Amount', 18, 2);

            $table->index('FeeTypeId', 'IX_InvoiceItem_FeeTypeId');
            $table->index('FeeRateId', 'IX_InvoiceItem_FeeRateId');

            $table->foreign('InvoiceId', 'FK_InvoiceItem_Invoice')
                ->references('InvoiceId')->on('Invoice')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('FeeTypeId', 'FK_InvoiceItem_FeeType')
                ->references('FeeTypeId')->on('FeeType')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('FeeRateId', 'FK_InvoiceItem_FeeRate')
                ->references('FeeRateId')->on('FeeRate')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('InvoiceItem');
    }
};
