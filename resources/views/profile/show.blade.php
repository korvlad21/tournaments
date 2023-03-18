@extends('layouts.app')

@section('content')
    <profile-show :slug="{{ json_encode($slug)}}"></profile-show>
@endsection
