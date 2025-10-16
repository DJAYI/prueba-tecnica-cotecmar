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
            $table->id();
            $table->char('name', 3);

            $table->integer('theorical_weight');
            $table->decimal('real_weight', 8, 1);

            $table->enum('status', ['manufactured', 'pending'])->default('pending');

            // Foreign key to Block
            $table->string('block_id');

            // Foreign key for User
            $table->string('user_id')->nullable();

            $table->date('manufactured_at')->nullable();


            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
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
