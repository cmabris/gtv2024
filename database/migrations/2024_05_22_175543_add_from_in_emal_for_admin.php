<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('email_for_admin', function (Blueprint $table) {
            $table->string('from')->comment('Destinatario del correo');
        });
    }

    public function down()
    {
        Schema::table('email_for_admin', function (Blueprint $table) {
            $table->dropColumn('from');
        });
    }
};