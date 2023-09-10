@extends('layouts.app')

@section('content')
    <stage-show :id="{{ json_encode($id)}}"></stage-show>
@endsection
