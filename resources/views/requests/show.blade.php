<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request') }} #{{ $serviceRequest->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p><strong>Requester:</strong> {{ $serviceRequest->requester_name }}</p>
                    <p><strong>Email:</strong> {{ $serviceRequest->requester_email }}</p>
                    <p><strong>Item:</strong> {{ $serviceRequest->item_name }}</p>
                    <p><strong>Quantity:</strong> {{ $serviceRequest->quantity }}</p>
                    <p><strong>Purpose:</strong> {{ $serviceRequest->purpose }}</p>
                    <p><strong>Status:</strong> {{ $serviceRequest->status }}</p>

                    @can('updateStatus', $serviceRequest)
                        <form method="POST" action="{{ route('requests.updateStatus', $serviceRequest) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-control">
                                <option value="pending" @selected($serviceRequest->status === 'pending')>Pending</option>
                                <option value="approved" @selected($serviceRequest->status === 'approved')>Approved</option>
                                <option value="rejected" @selected($serviceRequest->status === 'rejected')>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>