@extends('layouts.app')

@section('content')
    <profile-update :slug="{{ json_encode($slug)}}"></profile-update>
@endsection
