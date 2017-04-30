<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorManagerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createUsersTable();
        $this->createRolesTable();
        $this->createAbilitiesTable();
        $this->createPermissionsTable();
        $this->createProfilesTable();
    }

    protected function createUsersTable()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->morphs('actorable');
            $table->timestamps();
        });
    }

    protected function createRolesTable()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->boolean('granted')->default(true);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');
        });
    }

    protected function createAbilitiesTable()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
    }

    protected function createPermissionsTable()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->morphs('model');
            $table->integer('ability_id')->unsigned();
            $table->boolean('granted')->default(true);

            $table->foreign('ability_id')
                ->references('id')->on('abilities')
                ->onDelete('cascade');
        });
    }

    protected function createProfilesTable()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('biography')->nullable();
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
        Schema::drop('profiles');
        Schema::drop('role_permission');
        Schema::drop('user_permission');
        Schema::drop('abilities');
        Schema::drop('user_role');
        Schema::drop('roles');
        Schema::drop('users');
    }
}
