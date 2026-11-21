<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Floor', function (Blueprint $table) {
            $table->increments('FloorId');
            $table->unsignedInteger('BuildingId');
            $table->integer('FloorNumber');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->unique(['BuildingId', 'FloorNumber'], 'UQ_Floor_Building_FloorNumber');
            $table->foreign('BuildingId', 'FK_Floor_Building')
                ->references('BuildingId')->on('Building')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Floor');
    }
};
