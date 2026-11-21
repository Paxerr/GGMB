<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('NotificationTarget', function (Blueprint $table) {
            $table->increments('NotificationTargetId');
            $table->unsignedInteger('NotificationId');
            $table->unsignedInteger('BuildingId')->nullable();
            $table->unsignedInteger('FloorId')->nullable();
            $table->unsignedInteger('ApartmentId')->nullable();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('BuildingId', 'IX_NotificationTarget_BuildingId');
            $table->index('FloorId', 'IX_NotificationTarget_FloorId');
            $table->index('ApartmentId', 'IX_NotificationTarget_ApartmentId');

            $table->foreign('NotificationId', 'FK_NotificationTarget_Notification')
                ->references('NotificationId')->on('Notification')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('BuildingId', 'FK_NotificationTarget_Building')
                ->references('BuildingId')->on('Building')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('FloorId', 'FK_NotificationTarget_Floor')
                ->references('FloorId')->on('Floor')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('ApartmentId', 'FK_NotificationTarget_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NotificationTarget');
    }
};
