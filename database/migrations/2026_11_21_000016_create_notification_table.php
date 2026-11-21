<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Notification', function (Blueprint $table) {
            $table->increments('NotificationId');
            $table->unsignedInteger('CreatedByUserId');
            $table->string('Title', 200);
            $table->text('Content');
            $table->string('TargetType', 20);
            $table->timestamp('CreatedAt')->useCurrent();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('CreatedByUserId', 'IX_Notification_CreatedByUserId');

            $table->foreign('CreatedByUserId', 'FK_Notification_CreatedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Notification');
    }
};
