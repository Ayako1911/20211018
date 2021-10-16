<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('fullname');
	        $table->tinyInteger('gender')->unsigned()->comment('性別 1:男、2:女');
            $table->string('email');
	        $table->char('postcode', 8);
	        $table->string('address');
	        $table->string('building_name')->nullable();
            $table->text('opinion');
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
