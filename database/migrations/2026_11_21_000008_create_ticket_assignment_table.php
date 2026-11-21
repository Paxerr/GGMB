<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TicketAssignment', function (Blueprint $table) {
            $table->increments('TicketAssignmentId');
            $table->unsignedInteger('TicketId')->unique('UQ_TicketAssignment_Ticket');
            $table->unsignedInteger('AssignedToUserId');
            $table->timestamp('AssignedAt')->useCurrent();

            $table->index('AssignedToUserId', 'IX_TicketAssignment_AssignedToUserId');

            $table->foreign('TicketId', 'FK_TicketAssignment_Ticket')
                ->references('TicketId')->on('Ticket')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('AssignedToUserId', 'FK_TicketAssignment_AssignedToUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TicketAssignment');
    }
};
