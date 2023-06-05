@extends('layouts.app')

@section('content')
    <event-show :id="{{ json_encode($id)}}"></event-show>
@endsection
