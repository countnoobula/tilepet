@extends('adam::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('adam.name') !!}</p>
@endsection
