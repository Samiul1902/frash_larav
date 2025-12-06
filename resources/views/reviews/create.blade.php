@include('partials.header')

<div class="max-w-4xl mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Leave a Review</h2>

    <div class="bg-gray-50 border-l-4 border-blue-500 text-gray-700 p-4 mb-6">
        <p class="font-bold">Service: {{ $appointment->service->title }}</p>
        <p>Stylist: {{ $appointment->staff->name }}</p>
        <p class="text-xs">Date: {{ $appointment->start_time->format('M d, Y') }}</p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
        <input type="hidden" name="service_id" value="{{ $appointment->service_id }}">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">
                Rating
            </label>
            <div class="flex items-center space-x-2">
                @for($i = 5; $i >= 1; $i--)
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="form-radio text-yellow-500 h-5 w-5" required>
                        <span class="ml-2">{{ $i }} Stars</span>
                    </label>
                @endfor
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                Comment (Optional)
            </label>
            <textarea name="comment" id="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tell us about your experience..."></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit Review
            </button>
            <a href="{{ route('appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancel
            </a>
        </div>
    </form>
</div>

@include('partials.footer')
