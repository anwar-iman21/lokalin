<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications_own()->latest()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications_own()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return $notification->url
            ? redirect($notification->url)
            : back();
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications_own()->where('is_read', false)->update(['is_read' => true]);

        return back();
    }
}
