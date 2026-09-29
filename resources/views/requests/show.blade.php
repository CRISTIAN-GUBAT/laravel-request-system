@extends('layouts.app')

@section('content')
    <h1>Request #{{ $serviceRequest->id }}</h1>

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
            <select name="status">
                <option value="pending" @selected($serviceRequest->status === 'pending')>Pending</option>
                <option value="approved" @selected($serviceRequest->status === 'approved')>Approved</option>
                <option value="rejected" @selected($serviceRequest->status === 'rejected')>Rejected</option>
            </select>
            <button type="submit">Update Status</button>
        </form>
    @endcan
@endsection