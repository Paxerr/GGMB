<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TicketAttachment', function (Blueprint $table) {
            $table->increments('TicketAttachmentId');
            $table->unsignedInteger('TicketId');
            $table->string('FileName', 255);
            $table->string('FilePath', 500);
            $table->string('ContentType', 100)->nullable();
            $table->unsignedBigInteger('FileSize')->nullable();
            $table->unsignedInteger('UploadedByUserId');
            $table->timestamp('UploadedAt')->useCurrent();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('UploadedByUserId', 'IX_TicketAttachment_UploadedByUserId');

            $table->foreign('TicketId', 'FK_TicketAttachment_Ticket')
                ->references('TicketId')->on('Ticket')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('UploadedByUserId', 'FK_TicketAttachment_UploadedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TicketAttachment');
    }
};
