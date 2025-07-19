<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalChatsTable extends Migration
{
    public function up()
    {
        Schema::create('global_chats', function (Blueprint $table) {
            $table->id();
            $table->text('message');  // Stores the chat message
            $table->string('sender'); // Indicates whether the sender is a user or assistant
            $table->timestamps();     // Automatically tracks created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_chats');
    }
}
