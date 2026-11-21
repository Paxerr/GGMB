<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ApartmentResident', function (Blueprint $table) {
            $table->increments('ApartmentResidentId');
            $table->unsignedInteger('ApartmentId');
            $table->unsignedInteger('UserId');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->string('Status', 20)->default('ACTIVE');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('UserId', 'IX_ApartmentResident_UserId');
            $table->index(['ApartmentId', 'Status'], 'IX_ApartmentResident_Apartment_Status');

            $table->foreign('ApartmentId', 'FK_ApartmentResident_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('UserId', 'FK_ApartmentResident_User')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ApartmentResident');
    }
};
