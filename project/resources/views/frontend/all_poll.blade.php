@extends('layouts.front')

@section('contents')
<div class="container">
    <h1>All Polls</h1>
    @forelse ($polls ?? [] as $poll)
        <div class="poll-item">
            <h4>{{ $poll->question }}</h4>
        </div>
    @empty
        <p>No polls available.</p>
    @endforelse
</div>
@endsection
