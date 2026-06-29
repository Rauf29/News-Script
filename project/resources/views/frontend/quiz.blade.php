@extends('layouts.front')

@section('contents')
<div class="container">
    <h1>{{ $data->title ?? 'Quiz' }}</h1>
    <div>{!! $data->description ?? '' !!}</div>
</div>
@endsection
