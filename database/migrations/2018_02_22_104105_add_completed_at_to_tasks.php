<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletedAtToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function($table) {
            $table->datetime('completed_at')->nullable();
        });    

        /* 2. Update each post with a shiny new slug */
        $rows = DB::table('tasks')->get(['id', 'completed']);
        foreach ($rows as $row) {
            DB::table('tasks')
                ->where('completed', 1)
                ->update(['completed_at' => NOW()]);
        }
        
        Schema::table('tasks', function($table) {
            $table->dropColumn('completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function($table) {
            $table->boolean('completed')->default(false);
        });   

        /* 2. Update each post with a shiny new slug */
        $rows = DB::table('tasks')->get(['id', 'completed_at']);
        foreach ($rows as $row) {
            DB::table('tasks')
                ->whereNotNull('completed_at')
                ->update(['completed' => 1]);
        }
        
        Schema::table('tasks', function($table) {
            $table->dropColumn('completed_at');
        });

    }
}
