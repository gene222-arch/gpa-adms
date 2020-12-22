<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReliefGoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relief_good', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('relief_good_id');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_received')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            // unique id's
            $table->unique(['user_id', 'relief_good_id']);
            // constraints
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('relief_good_id')
                ->references('id')
                ->on('relief_goods')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relief_good');
    }
}
