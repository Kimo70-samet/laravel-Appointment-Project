<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index(Request $request): View
    {
        $query = Appointment::query();
        
        // Apply filters
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
                case 'today':
                    $query->whereDate('start_time', today());
                    break;
            }
        }
        
        $appointments = $query->orderBy('start_time', 'asc')->paginate(10);
        $upcomingAppointments = Appointment::upcoming()->orderBy('start_time', 'asc')->take(5)->get();
        
        return view('appointments.index', compact('appointments', 'upcomingAppointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(): View
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $validated['user_id'] = auth()->id();

        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'تم إنشاء الموعد بنجاح!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment): View
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment): View
    {
        // التحقق من الصلاحيات - المدير يمكنه تعديل أي موعد، المستخدم العادي مواعيده فقط
        if (!auth()->user()->canManageAppointment($appointment)) {
            abort(403, 'غير مصرح لك بتعديل هذا الموعد.');
        }

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        // التحقق من الصلاحيات
        if (!auth()->user()->canManageAppointment($appointment)) {
            abort(403, 'غير مصرح لك بتعديل هذا الموعد.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'تم تحديث الموعد بنجاح!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        // التحقق من الصلاحيات
        if (!auth()->user()->canManageAppointment($appointment)) {
            abort(403, 'غير مصرح لك بحذف هذا الموعد.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح!');
    }

    /**
     * Get appointments for calendar view.
     */
    public function calendar(): View
    {
        $appointments = Appointment::all()->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->name,
                'start' => $appointment->start_time->toISOString(),
                'end' => $appointment->end_time->toISOString(),
                'backgroundColor' => '#3788d8',
                'borderColor' => '#3788d8',
            ];
        });

        return view('appointments.calendar', compact('appointments'));
    }
}
