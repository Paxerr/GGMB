<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MeterReading', function (Blueprint $table) {
            $table->increments('MeterReadingId');
            $table->unsignedInteger('ApartmentId');
            $table->unsignedInteger('FeeTypeId');
            $table->unsignedInteger('RecordedByUserId');
            $table->char('BillingPeriod', 7);
            $table->decimal('PreviousReading', 12, 3);
            $table->decimal('CurrentReading', 12, 3);
            $table->decimal('Consumption', 12, 3);
            $table->timestamp('RecordedAt')->useCurrent();

            $table->unique(['ApartmentId', 'FeeTypeId', 'BillingPeriod'], 'UQ_MeterReading_Apartment_FeeType_Period');
            $table->index('FeeTypeId', 'IX_MeterReading_FeeTypeId');
            $table->index('RecordedByUserId', 'IX_MeterReading_RecordedByUserId');

            $table->foreign('ApartmentId', 'FK_MeterReading_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('FeeTypeId', 'FK_MeterReading_FeeType')
                ->references('FeeTypeId')->on('FeeType')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('RecordedByUserId', 'FK_MeterReading_RecordedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MeterReading');
    }
};
