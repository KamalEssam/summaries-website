<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {

            $table->increments('id');

            $table->date('match_date');
            $table->time('match_time');

            $table->integer('team_home_id')->unsigned()->nullable();            
            $table->foreign('team_home_id')->references('id')->on('teams')->onDelete('set null');

            $table->integer('team_home_result')->nullable();
            $table->integer('team_away_result')->nullable();

            $table->integer('team_away_id')->unsigned()->nullable();            
            $table->foreign('team_away_id')->references('id')->on('teams')->onDelete('set null');

            $table->integer('league_id')->unsigned()->nullable();            
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('set null');

            $table->integer('channel_id')->unsigned()->nullable();            
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('set null');

            $table->integer('commentator_id')->unsigned()->nullable();            
            $table->foreign('commentator_id')->references('id')->on('commentators')->onDelete('set null');

            $table->string('live_stream_url')->nullable();
            $table->string('summary_url')->nullable();
            $table->string('goals_url')->nullable();

            $table->integer('finished');

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
        Schema::dropIfExists('matches');
    }
}
