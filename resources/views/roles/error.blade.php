@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <small>{{ config('app.name') }}</small>
                <h2>{{ $exception->getMessage() }}</h2>
                <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
            </div>
        </div>
    </div>

@endsection