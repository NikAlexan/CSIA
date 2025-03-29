<?php
namespace App\Http\Controllers;

use App\Models\NotificationSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationScheduleController extends Controller
{
    public function index()
    {
        return NotificationSchedule::all();
    }

    public function create()
    {
        return view('notifications.create', ['users' => User::all()]);
    }

    public function store(Request $request)
{
    $data = $request->all();

    // Добавляем секунды, если только HH:MM
    if (!empty($data['notify_at']) && strlen($data['notify_at']) === 5) {
        $data['notify_at'] .= ':00';
    }

    // Теперь можно валидировать
    $validated = validator($data, [
        'user_id'   => 'required|exists:users,id',
        'type'      => 'required|string',
        'notify_at' => 'nullable|date_format:H:i:s',
        'message'   => 'nullable|string',
        'enabled'   => 'boolean',
    ])->validate();

    $notification = NotificationSchedule::create($validated);
    return response()->json($notification, 201);
}


    public function show(NotificationSchedule $notificationSchedule)
    {

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
