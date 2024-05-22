<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('team_leader');
            $table->foreignId('team_leader_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('name', 100)->unique()->change();
            $table->string('email_alias',100)->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table){
            $table->string('name', 50);
            $table->dropForeign('teams_team_leader_id_foreign');
        });
    }
};
