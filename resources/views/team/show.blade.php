@extends('layouts.app')

@section('content')
    <team-show :id="{{ json_encode($id)}}"></team-show>
@endsection
