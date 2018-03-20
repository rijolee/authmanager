<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('menu_id',5);
            $table->string('parent_id',5);
            $table->string('menu_nm',100);
            $table->string('menu_order',3);
            $table->string('system_nm',10);
            $table->string('url',100)->nullable();
            $table->string('desc',300)->nullable();
            $table->string('class',100)->nullable();
            
            
            $table->boolean('disp_yn')->default(0);
            

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
        Schema::dropIfExists('menus');
    }
}
