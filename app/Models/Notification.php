<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'message'
    ];

    public function notificationProducts(){
        return $this->hasMany(NotificationProduct::class,'notification_id');
    }
}
