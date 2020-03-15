<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('app_id');
            $table->string('channel')->comment('email,telegram,web');
            $table->string('from')->nullable();
            $table->string('description')->nullable();
            $table->string('to');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->string('attachment')->nullable();
            $table->text('response_text')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->unsignedInteger('trying_send')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
