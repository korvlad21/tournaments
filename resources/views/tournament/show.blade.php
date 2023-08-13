@extends('layouts.app')

@section('content')
    <tournament-show :id="{{ json_encode($id)}}"></tournament-show>
@endsection
