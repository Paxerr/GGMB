<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('FeeType', function (Blueprint $table) {
            $table->increments('FeeTypeId');
            $table->string('Code', 30)->unique('UQ_FeeType_Code');
            $table->string('Name', 100);
            $table->string('Description', 500)->nullable();
            $table->boolean('IsActive')->default(true);
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FeeType');
    }
};
