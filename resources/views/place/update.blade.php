@extends('layouts.app')

@section('content')
    @if(isset($id))
        <place-update :id="{{ json_encode($id)}}"></place-update>
    @else
        <place-update></place-update>
    @endif
@endsection
