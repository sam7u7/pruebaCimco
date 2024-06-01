<?php

use App\Models\producto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('id_producto');
            $table->foreignIdFor(model:producto::class)->constrained();
            $table->timestamps();
            //$table->foreign('id_producto')->references('id')->on('producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodegas');
    }
};
