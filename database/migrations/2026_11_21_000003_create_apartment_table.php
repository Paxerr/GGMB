<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Apartment', function (Blueprint $table) {
            $table->increments('ApartmentId');
            $table->unsignedInteger('FloorId');
            $table->string('ApartmentNumber', 20);
            $table->string('Status', 20)->default('AVAILABLE');
            $table->string('Description', 500)->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->unique(['FloorId', 'ApartmentNumber'], 'UQ_Apartment_Floor_Number');
            $table->foreign('FloorId', 'FK_Apartment_Floor')
                ->references('FloorId')->on('Floor')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Apartment');
    }
};
