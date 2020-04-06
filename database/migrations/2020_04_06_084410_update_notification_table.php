<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function(Blueprint $table){
            $table->dropColumn(['channel']);

            $table->text('app')->nullable()->after('app_id');
            $table->unsignedBigInteger('channel_id')->after('app');
            $table->unsignedBigInteger('template_id')->after('channel_id');
            $table->text('data')->after('body')->nullable();

            $table->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->onUpdate('cascade');

            $table->foreign('template_id')
                ->references('id')
                ->on('templates')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
