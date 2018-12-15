<?php

namespace App\Models;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NotificationUserViewed extends Model
{
	protected $table = 'notification_userviewed';

    protected $fillable = [
		'notification_id',
		'user_id',
		'ww',
		'app',
	];

	public function notifications()
	{
		return $this->belongsToMany(Notification::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class);
	}

}
