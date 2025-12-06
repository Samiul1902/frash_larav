@include('partials.header')

<div class="max-w-4xl mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Book an Appointment</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="service_id">
                Select Service
            </label>
            <select name="service_id" id="service_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Choose a Service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->title }} (৳{{ $service->price }} - {{ $service->duration_minutes }} mins)</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="staff_id">
                Select Stylist
            </label>
            <select name="staff_id" id="staff_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Choose a Stylist --</option>
                @foreach($staff as $member)
                    <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->specialization }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="appointment_date">
                Date
            </label>
            <input type="date" name="appointment_date" id="appointment_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="appointment_time">
                Time
            </label>
            <input type="time" name="appointment_time" id="appointment_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Confirm Booking
            </button>
        </div>
    </form>
</div>

@include('partials.footer')
