<?php

namespace App\Models;

use App\Models\NotificationUserDeleted;
use App\Models\NotificationUserViewed;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = ['notification_title','notification_content',
                            'notification_type','visible_to_app',
                            'visible_to_widget','publish_date','expiry_date','images'];

    public function notificationUserViewed(){
        return $this->hasMany(NotificationUserViewed::class,'notification_id');
    }

    public function notificationUserDeleted(){
        return $this->hasMany(NotificationUserDeleted::class,'notification_id');
    }
    
}
