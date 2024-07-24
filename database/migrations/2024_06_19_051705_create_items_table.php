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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('type')->default('number')->comment('number, ticket');
            $table->integer('menu_id')->default('0');
            $table->integer('input_value')->nullable();
            $table->integer('input_ticket')->default('0');
            $table->integer('input_value_new')->nullable();
            $table->integer('input_ticket_new')->default('0');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->integer('adder_id');
            $table->integer('verifier_id');
            $table->integer('viewer_id')->default('0');
            $table->timestamp('added_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
