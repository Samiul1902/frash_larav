<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'appointments_today' => Appointment::whereDate('start_time', today())->count(),
            'total_appointments' => Appointment::count(),
            'revenue_total' => Invoice::where('status', 'paid')->sum('amount'),
            'active_staff' => Staff::where('is_active', true)->count(),
        ];

        $recent_appointments = Appointment::with(['user', 'staff', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments'));
    }
}
