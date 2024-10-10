<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Existing Donations</h3>
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($donations as $donation)
                    <li class="py-4 flex items-center justify-between space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $donation->description }}</p>
                            <p class="text-sm text-gray-500 truncate">Target: {{ number_format($donation->target_amount,
                                2) }} |
                                Current: {{ number_format($donation->current_amount, 2) }}</p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold">
                            @if(!$donation->completed)
                            <a href="{{ route('donations.form', $donation->id) }}"
                                class="px-2.5 py-1.5 text-xs font-medium text-white bg-green-700 rounded mr-3">Contribute</a>
                            @endif
                            <span class="text-xs font-semibold text-gray-400">{{ $donation->completed ? 'Completed'
                                :
                                'Active'
                                }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>