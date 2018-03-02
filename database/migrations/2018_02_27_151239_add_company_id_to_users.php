<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class AddCompanyIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('company_id')->default(0);
        });
        
        // $user = new User;
        // $user->name = "Signar Kristiansen";
        // $user->email = "signar@siprosoft.com";
        // $user->password = '$2y$10$PIplAFzPnI/HVprjKUHF/OW4MZjfmloOZpr4N2bZTsH0B2TcnCetq';
        // $user->is_superuser = true;
        // $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('company_id');
        });
    }
}
