<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Vehicle', function (Blueprint $table) {
            $table->increments('VehicleId');
            $table->unsignedInteger('ApartmentId');
            $table->string('LicensePlate', 20);
            $table->string('VehicleType', 30);
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('ApartmentId', 'IX_Vehicle_ApartmentId');

            $table->foreign('ApartmentId', 'FK_Vehicle_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Vehicle');
    }
};
