<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TicketResponse', function (Blueprint $table) {
            $table->increments('TicketResponseId');
            $table->unsignedInteger('TicketId');
            $table->unsignedInteger('RespondedByUserId');
            $table->text('Content');
            $table->timestamp('CreatedAt')->useCurrent();

            $table->index('RespondedByUserId', 'IX_TicketResponse_RespondedByUserId');

            $table->foreign('TicketId', 'FK_TicketResponse_Ticket')
                ->references('TicketId')->on('Ticket')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('RespondedByUserId', 'FK_TicketResponse_RespondedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TicketResponse');
    }
};
