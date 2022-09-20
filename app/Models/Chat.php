<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_seen_at' => 'datetime',
        'is_archived' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'is_archived',
        'last_message',
        'last_seen_at'
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
