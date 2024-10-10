<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Donations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Your Created Donations</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($user_donations as $donation)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-2">{{ $donation->description }}</h3>
                            <p class="mb-2">Target: {{ number_format($donation->target_amount, 2) }}</p>
                            <p class="mb-2">Current: {{ number_format($donation->current_amount, 2) }}</p>
                            <p class="mb-2">Status: {{ $donation->completed ? 'Completed' : 'Active' }}</p>
                            <a href="{{ route('donations.edit', $donation->id) }}"
                                class="px-2.5 py-1.5 text-xs font-medium text-white bg-blue-700 rounded">Edit</a>
                        </div>
                        @empty
                        <p>You haven't created any donations yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>