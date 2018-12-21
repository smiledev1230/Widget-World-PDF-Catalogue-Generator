<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationUserDeleted;
use App\Models\NotificationUserViewed;

class NotificationsController extends Controller
{
    //
    public function getNotification(Request $request)
    {
        $user_id = $request->user_id;
        $pms_deleted_ids = NotificationUserDeleted::select('notification_id')->where('ww', '0');
        $deleted_ids = NotificationUserDeleted::where('ww', '1')
            ->where('user_id', $user_id)
            ->union($pms_deleted_ids)
            ->pluck('notification_id')
            ->toArray();

        $notification_node = DB::table('notifications AS n')
            ->select('n.id', 'n.notification_title as title', 'n.notification_content as content', 'n.notification_type as type', 'images', 'v.ww AS state')
            ->leftJoin('notification_userviewed AS v', function ($join) use ($user_id) {
                $join->on('n.id', '=', 'v.notification_id')
                    ->where('v.user_id', '=', $user_id);
            })
            ->where('visible_to_widget', '1')
            ->whereNotIn('n.id', $deleted_ids)
            ->orderBy('n.updated_at', 'desc')
            ->get();
        $notifications = $notification_node->map(function ($row) {
            $row->content = str_replace('<p>', '', $row->content);
            $row->content = str_replace('</p>', '', $row->content);
            $image_path = json_decode($row->images);
            $row->images = sizeof($image_path) > 0 ? $image_path[0] : '';
            $row->type = $row->type ? $row->type : 'text';
            if (!$row->state) $row->state =0;
            return $row;
        });
        return response()->json($notifications);
    }

    public function updateNotificationView(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'notification_id' => 'required',
        ]);
        $notificationViewedNode = notificationUserViewed::where('user_id', $request->user_id)->where('notification_id', $request->notification_id);
        $existingUserViewed = $notificationViewedNode->first();
        if (isset($existingUserViewed)) {
            $notificationViewedNode->update(array('ww' => 1));
            return response()->json(['message' => 'success']);
        } else {
            $notificationUserViewed = new NotificationUserViewed;
            $notificationUserViewed->notification_id = $request->notification_id;
            $notificationUserViewed->user_id = $request->user_id;
            $notificationUserViewed->ww = 1;
            if ($notificationUserViewed->save()) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'failed to update notification view']);
            }
        }
    }

    public function updateNotificationDelete(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'notification_id' => 'required',
        ]);
        $notificationDeletedNode = NotificationUserDeleted::where('user_id', $request->user_id)->where('notification_id', $request->notification_id);
        $existingUserDeleted = $notificationDeletedNode->first();
        if (isset($existingUserDeleted)) {
            $notificationDeletedNode->update(array('ww' => 1));
            return response()->json(['message' => 'success']);
        } else {
            $notificationUserViewed = new NotificationUserDeleted;
            $notificationUserViewed->notification_id = $request->notification_id;
            $notificationUserViewed->user_id = $request->user_id;
            $notificationUserViewed->ww = 1;
            if ($notificationUserViewed->save()) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'failed to delete notification']);
            }
        }
    }
}
