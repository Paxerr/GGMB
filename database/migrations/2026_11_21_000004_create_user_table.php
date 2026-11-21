<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('UserId');
            $table->string('UserName', 50)->unique('UQ_User_UserName');
            $table->string('PasswordHash', 255);
            $table->string('FullName', 100);
            $table->string('Phone', 20)->nullable();
            $table->string('Email', 255)->nullable();
            $table->string('CitizenId', 20)->nullable();
            $table->string('Role', 30);
            $table->string('Department', 100)->nullable();
            $table->string('Status', 20)->default('ACTIVE');
            $table->rememberToken();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('User');
    }
};
