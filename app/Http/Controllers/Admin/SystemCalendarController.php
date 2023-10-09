<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Http\Controllers\Controller;

class SystemCalendarController extends Controller
{

    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['client', 'employee'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->start_time) {
                continue;
            }

            $events[] = [
                'title' => ($appointment->confirmed ? '✓ ' : '') . $appointment->client->name . ' ('.$appointment->employee->name.')',
                'start' => $appointment->start_time,
                'end' => $appointment->finish_time,
                'url'   => route('admin.appointments.edit', $appointment->id),
                'backgroundColor' => $appointment->employee->color
            ];
        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
