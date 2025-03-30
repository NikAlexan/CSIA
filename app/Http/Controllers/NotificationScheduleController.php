<?php
namespace App\Http\Controllers;

use App\Models\NotificationSchedule;
use App\Models\User;
use App\NotificationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationScheduleController extends Controller
{
    public function index()
    {
        $notificationsSchedule = NotificationSchedule::where('user_id', Auth::user()->id)->get();

        return Inertia::render('NotificationSchedule/List', [
            "notificationsSchedule" => $notificationsSchedule,
        ]);
    }

    public function create()
    {
        $types = NotificationTypes::array();
        return Inertia::render('NotificationSchedule/Create', ['types' => $types]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validated = validator($data, [
            'type' => 'required|string',
            'notify_at' => 'nullable|date_format:H:i:s',
            'message' => 'nullable|string',
            'enabled' => 'boolean',
        ])->validate();

        NotificationSchedule::create(['user_id' => Auth::user()->id, ...$validated]);
        return redirect()->route('notifications.schedule.index');
    }


    public function edit(NotificationSchedule $notificationSchedule)
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
        return redirect()->route('notifications.schedule.index');
    }
}
