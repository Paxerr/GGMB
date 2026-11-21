<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('FeeRate', function (Blueprint $table) {
            $table->increments('FeeRateId');
            $table->unsignedInteger('FeeTypeId');
            $table->decimal('UnitPrice', 18, 2);
            $table->date('EffectiveFrom');
            $table->date('EffectiveTo')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();

            $table->index(['FeeTypeId', 'EffectiveFrom'], 'IX_FeeRate_FeeType_EffectiveFrom');

            $table->foreign('FeeTypeId', 'FK_FeeRate_FeeType')
                ->references('FeeTypeId')->on('FeeType')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FeeRate');
    }
};
