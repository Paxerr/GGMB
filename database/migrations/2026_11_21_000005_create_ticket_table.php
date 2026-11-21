<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Ticket', function (Blueprint $table) {
            $table->increments('TicketId');
            $table->unsignedInteger('CreatedByUserId');
            $table->unsignedInteger('ApartmentId')->nullable();
            $table->string('Subject', 200);
            $table->text('Description');
            $table->string('Status', 20)->default('OPEN');
            $table->string('Category', 30);
            $table->timestamp('ResolvedAt')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable()->useCurrentOnUpdate();
            $table->boolean('IsDeleted')->default(false);
            $table->timestamp('DeletedAt')->nullable();

            $table->index('CreatedByUserId', 'IX_Ticket_CreatedByUserId');
            $table->index('ApartmentId', 'IX_Ticket_ApartmentId');
            $table->index('Status', 'IX_Ticket_Status');

            $table->foreign('CreatedByUserId', 'FK_Ticket_CreatedByUser')
                ->references('UserId')->on('User')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('ApartmentId', 'FK_Ticket_Apartment')
                ->references('ApartmentId')->on('Apartment')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Ticket');
    }
};
