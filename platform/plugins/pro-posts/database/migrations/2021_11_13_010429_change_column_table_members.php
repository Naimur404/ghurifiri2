<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTableMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->text('favorite_posts')->nullable()->change();
            $table->text('bookmark_posts')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->json('favorite_posts')->nullable()->change();
            $table->json('bookmark_posts')->nullable()->change();
        });
    }
}
