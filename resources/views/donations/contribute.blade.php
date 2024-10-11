<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Contribute to Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('donations.contribute', $donation->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="donation_id" value="{{ $donation->id }}">

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Contribution
                                Amount</label>
                            <input type="number" id="amount" name="amount"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="$0.00" step="0.01" min="0" required>
                        </div>

                        <div class="mb-4">
                            <label for="preset_amounts" class="block text-sm font-medium text-gray-700">Quick
                                Contribution Options:</label>
                            <select id="preset_amounts" name="preset_amounts"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                onchange="updateAmount(this)">
                                <option value="">Select Amount</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="25">25%</option>
                                <option value="50">50%</option>
                                <option value="100">100%</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Contribute
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function updateAmount(select) {
        const amountInput = document.getElementById('amount');
        if (select.value !== '') {
            const percentage = parseFloat(select.value);
            const targetAmount = {{ $donation->target_amount }};
            const calculatedAmount = (percentage / 100) * targetAmount;
            amountInput.value = calculatedAmount.toFixed(2);
        } else {
            amountInput.value = '';
        }
    }
</script>