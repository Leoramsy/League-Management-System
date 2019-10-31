<?php

use App\Models\System\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();            
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        
        // My user acount
        User::create([
            'name' => 'Leopold Ramutsamaya',
            'email' => 'leoramsy@gmail.com',
            'password' => Hash::make('tester'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
