
@extends('admin.dashboard')

@section('content')

    <div class="mb-5">
        <a href="{{ route('appointment.create') }}">
            <button class="btn bg-sidebar text-white">+ Add New Appointment</button>
        </a>
        <a href="{{ route('display') }}">
            <button class="btn bg-sidebar text-white"> Edit Appointment</button>
        </a>
    </div>
    <hr>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                View all appointments
            </div>
            <div class="panel-body" >
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
        </div>
    </div>
@endsection
