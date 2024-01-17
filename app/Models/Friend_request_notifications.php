<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Friend_request_notifications extends Model
{
    use HasFactory;
    protected $fillable  = [
        'sender_id',
        'receiver_id',
        'read'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Relationship: Sender of the notification
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


}



