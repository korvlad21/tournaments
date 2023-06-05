@extends('layouts.app')

@section('content')
    @if(isset($event_id))
        <tournament-update :event_id="{{ json_encode($event_id)}}"></tournament-update>
    @else
        <tournament-update></tournament-update>
    @endif
@endsection
