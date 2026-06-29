@extends('layouts.front')

@section('contents')
<div class="container">
    <h1>Poll Results</h1>
    @forelse ($polls ?? [] as $poll)
        <div class="poll-item">
            <h4>{{ $poll->question }}</h4>
        </div>
    @empty
        <p>No poll results available.</p>
    @endforelse
</div>
@endsection
