@extends('layouts.app')

@section('content')
    <tournament-add-teams :id="{{ json_encode($id)}}"></tournament-add-teams>
@endsection
