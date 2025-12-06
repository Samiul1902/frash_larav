<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { font-size: 12pt; }
            .shadow-lg { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-lg">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                <p class="text-gray-600">Smart Salon</p>
                <p class="text-sm text-gray-500">Dhaka, Bangladesh</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600">Invoice #: <strong>{{ $invoice->id }}</strong></p>
                <p class="text-gray-600">Date: {{ $invoice->issued_at->format('M d, Y') }}</p>
                <p class="text-gray-600 font-bold {{ $invoice->status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                    {{ strtoupper($invoice->status) }}
                </p>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-2">Bill To:</h3>
            <p>{{ $invoice->appointment->user->name }}</p>
            <p>{{ $invoice->appointment->user->email }}</p>
            <p>{{ $invoice->appointment->user->phone }}</p>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-2">Service</th>
                    <th class="text-left p-2">Stylist</th>
                    <th class="text-right p-2">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2 border-b">{{ $invoice->appointment->service->title }}</td>
                    <td class="p-2 border-b">{{ $invoice->appointment->staff->name }}</td>
                    <td class="p-2 border-b text-right">৳{{ $invoice->amount }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="p-2 text-right font-bold">Total:</td>
                    <td class="p-2 text-right font-bold">৳{{ $invoice->amount }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-center mt-12 mb-4 no-print">
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Print Invoice
            </button>
            <a href="{{ route('admin.appointments.index') }}" class="ml-4 text-gray-600 hover:underline">Back to Dashboard</a>
        </div>
        
        <div class="text-center text-xs text-gray-500 mt-8 pt-4 border-t">
            <p>Thank you for choosing Smart Salon!</p>
        </div>
    </div>
</body>
</html>
