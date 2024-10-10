<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modify Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('donations.update', $donation) }}" method="POST">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="id" value="{{ $donation->id }}">
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Enter donation description"
                                required>{{ $donation->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="target_amount" class="block text-sm font-medium text-gray-700">Target
                                Amount</label>
                            <input type="number" id="target_amount" name="target_amount"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{ $donation->target_amount }}" placeholder="$0.00" step="0.01" min="0" required>
                        </div>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update
                            Donation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>