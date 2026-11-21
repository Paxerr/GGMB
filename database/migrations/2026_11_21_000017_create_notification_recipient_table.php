<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('NotificationRecipient', function (Blueprint $table) {
            $table->increments('NotificationRecipientId');
            $table->unsignedInteger('NotificationId');
            $table->unsignedInteger('UserId');
            $table->boolean('IsRead')->default(false);
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->unique(['NotificationId', 'UserId'], 'UQ_NotificationRecipient_Notification_User');
            $table->index(['UserId', 'IsRead'], 'IX_NotificationRecipient_UserId_IsRead');

            $table->foreign('NotificationId', 'FK_NotificationRecipient_Notification')
                ->references('NotificationId')->on('Notification')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('UserId', 'FK_NotificationRecipient_User')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NotificationRecipient');
    }
};
