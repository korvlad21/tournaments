@extends('layouts.app')

@section('content')
    <place-show :id="{{ json_encode($id)}}"></place-show>
@endsection
