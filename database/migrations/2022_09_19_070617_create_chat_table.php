<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_archived')->default(false);
            $table->string('last_message', 1024);
            $table->timestamp('last_seen_at');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id');

            $table->foreign('chat_id')->references('id')->on('chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('chat_id');
        });
        Schema::dropIfExists('chats');
    }
};
