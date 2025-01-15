<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'progress', 'status', 'user_id'];

    /**
     * Relasi ke model Task.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
