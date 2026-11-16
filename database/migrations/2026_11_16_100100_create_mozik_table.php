<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mozik', function (Blueprint $table) {
            $table->id();
            $table->string('nev');
            $table->string('iranyitoszam', 4);
            $table->string('cim');
            $table->string('telefon', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mozik');
    }
};
