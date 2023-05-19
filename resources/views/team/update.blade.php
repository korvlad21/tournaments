@extends('layouts.app')

@section('content')
    @if(isset($id))
        <team-update :id="{{ json_encode($id)}}"></team-update>
    @else
        <team-update></team-update>
    @endif
@endsection
