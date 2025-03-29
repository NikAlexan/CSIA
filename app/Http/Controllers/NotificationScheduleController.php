<?php
namespace App\Http\Controllers;

use App\Models\NotificationSchedule;
use Illuminate\Http\Request;

class NotificationScheduleController extends Controller
{
    public function index()
    {
        return NotificationSchedule::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'type'      => 'required|string',
            'notify_at' => 'nullable|date_format:H:i:s',
            'message'   => 'nullable|string',
            'enabled'   => 'boolean',
        ]);

        $notification = NotificationSchedule::create($data);
        return response()->json($notification, 201);
    }

    public function show(NotificationSchedule $notificationSchedule)
    {
        return $notificationSchedule;
    }

    public function update(Request $request, NotificationSchedule $notificationSchedule)
    {
        $data = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'type'      => 'required|string',
            'notify_at' => 'nullable|date_format:H:i:s',
            'message'   => 'nullable|string',
            'enabled'   => 'boolean',
        ]);

        $notificationSchedule->update($data);
        return response()->json($notificationSchedule);
    }

    public function destroy(NotificationSchedule $notificationSchedule)
    {
        $notificationSchedule->delete();
        return response()->json(['message' => 'Notification schedule deleted']);
    }
}
