@extends('layouts.app')

@section('content')
    <contractor-show :id="{{ json_encode($id)}}"></contractor-show>
@endsection
