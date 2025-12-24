<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        try {
            $totalAppointments = Appointment::count();
            $upcomingAppointments = Appointment::where('start_time', '>', now())->count();
            $todayAppointments = Appointment::whereDate('start_time', today())->count();
            $recentAppointments = Appointment::orderBy('created_at', 'desc')->take(5)->get();

            $stats = [
                'total' => $totalAppointments,
                'upcoming' => $upcomingAppointments,
                'today' => $todayAppointments,
            ];

            return view('home', compact('stats', 'recentAppointments'));
        } catch (\Exception $e) {
            // في حالة وجود خطأ، أرسل بيانات افتراضية
            $stats = [
                'total' => 0,
                'upcoming' => 0,
                'today' => 0,
            ];
            $recentAppointments = collect([]);
            
            return view('home', compact('stats', 'recentAppointments'));
        }
    }
}
