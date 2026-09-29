@extends('layouts.app')

@section('content')
    <h1>My Requests</h1>

    @can('create', App\Models\ServiceRequest::class)
        <a href="{{ route('requests.create') }}">Create Request</a>
    @endcan

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->item_name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <a href="{{ route('requests.show', $request) }}">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $requests->links() }}
@endsection