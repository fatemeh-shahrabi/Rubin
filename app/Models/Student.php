<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_info',
        'skills_interests',
        'registration_status',
        'comments_notes',
    ];

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
