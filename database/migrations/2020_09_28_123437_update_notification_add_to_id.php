<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationAddToId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('project_id')->nullable()->after('app');
            $table->unsignedBigInteger('to_id')->nullable()->after('to');
            $table->text('to_user')->nullable()->after('to_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('id', function (Blueprint $table) {
            //
        });
    }
}
