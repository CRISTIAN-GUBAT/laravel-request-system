@extends('layouts.app')

@section('content')
    <h1>Create Request</h1>

    <form method="POST" action="{{ route('requests.store') }}">
        @csrf

        <label>Item Name</label>
        <input type="text" name="item_name" value="{{ old('item_name') }}" required maxlength="150">
        @error('item_name') <span>{{ $message }}</span> @enderror

        <label>Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity') }}" required min="1">
        @error('quantity') <span>{{ $message }}</span> @enderror

        <label>Purpose</label>
        <textarea name="purpose" required maxlength="2000">{{ old('purpose') }}</textarea>
        @error('purpose') <span>{{ $message }}</span> @enderror

        <button type="submit">Submit</button>
    </form>
@endsection