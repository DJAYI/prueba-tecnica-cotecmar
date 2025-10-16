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
        Schema::create('pieces', function (Blueprint $table) {
            $table->string('id', 12)->primary();
            $table->char('name', 3);
            $table->decimal('theorical_weight', 10, 2);
            $table->decimal('real_weight', 10, 2)->nullable();
            $table->enum('status', ['manufactured', 'pending'])->default('pending');
            $table->string('block_id', 8);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('manufactured_at')->nullable();
            $table->timestamps();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
