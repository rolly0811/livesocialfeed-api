<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('event_registered_users')->onDelete('cascade');
            $table->integer('category_id');
            $table->string('partner_name')->nullable();
            $table->string('registered_as')->nullable();
            $table->text('details')->nullable();
            $table->string('source')->nullable();
            $table->string('biggest_challenge')->nullable();
            $table->string('preferred_style')->nullable();
            $table->boolean('receive_updates')->default(false);
            $table->boolean('agreed_policy')->default(false);
            $table->string('registration_code', 100)->unique();
            $table->string('live_id', 20)->nullable();
            $table->string('target_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('attended_at')->nullable();
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
        Schema::dropIfExists('event_registrations');
    }
}
