@extends('layouts.app')

@section('content')
    @if(isset($id))
        <event-update :id="{{ json_encode($id)}}"></event-update>
    @else
        <event-update></event-update>
    @endif
@endsection
