<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'message', 'sender'
    ];

    public function student()
    {
        return $this->belongsTo(CsvFile::class, 'student_id');
    }

    public function chatMessages()
{
    return $this->hasMany(ChatMessage::class);
}

}
