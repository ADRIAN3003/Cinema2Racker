<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('cim');
            $table->boolean('szines')->default(true);
            $table->string('szinkron', 30)->nullable();
            $table->string('szarmazas', 120);
            $table->string('mufaj', 50)->nullable();
            $table->unsignedSmallInteger('hossz');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
