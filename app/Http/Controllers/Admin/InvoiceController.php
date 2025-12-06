<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Appointment;

class InvoiceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * We accept an appointment_id to pre-fill the invoice.
     */
    public function create(Request $request)
    {
        $appointment = Appointment::with('service', 'user')->findOrFail($request->get('appointment_id'));

        // Prevent duplicate invoices
        if ($appointment->invoice) {
            return redirect()->route('admin.invoices.show', $appointment->invoice->id);
        }

        return view('admin.invoices.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:invoices,appointment_id',
            'amount' => 'required|numeric',
        ]);

        $invoice = Invoice::create([
            'appointment_id' => $request->appointment_id,
            'amount' => $request->amount,
            'status' => 'paid', // Assuming generated means paid for now, or we can add a 'mark as paid' later
            'issued_at' => now(),
        ]);

        return redirect()->route('admin.invoices.show', $invoice->id)->with('success', 'Invoice generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with(['appointment.user', 'appointment.service', 'appointment.staff'])->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
    }
}
