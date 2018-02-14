<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('completed')->default(false);
            $table->integer('user_id');
            $table->integer('project_id');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });

        
        $user = new User;
        $user->name = "Signar Kristiansen";
        $user->email = "signar@siprosoft.com";
        $user->password = '$2y$10$PIplAFzPnI/HVprjKUHF/OW4MZjfmloOZpr4N2bZTsH0B2TcnCetq';
        $user->is_superuser = true;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
