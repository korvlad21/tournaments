@extends('layouts.app')

@section('content')
    @if(isset($id))
        <contractor-update :id="{{ json_encode($id)}}"></contractor-update>
    @else
        <contractor-update></contractor-update>
    @endif
@endsection
