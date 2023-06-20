<?php

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
        Schema::create('node_data', function (Blueprint $table) {
            $table->id();
            $table->integer('node_id')->default(0);
            $table->integer('type')->default(0);
            $table->text('content');
            $table->timestamps();

            /*
                Types:
                    0 -> Text
                    1 -> HTML
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('node_data');
    }
};
