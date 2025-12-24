@extends('admin.dashboard')

@section('content')
    <h4>Add Appointment</h4>
    <hr>
    <div>
        <form action="{{ route('appointment.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <form>

                <div class="form-group">
                    <label for="">Enter Name</label>
                    <input type="text" id="" aria-describedby="" name="name"
                           class="form-control @error('name') is-invalid @enderror">
                </div>

                @error('name')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="">Start Time</label>
                    <input type="datetime-local" id="" aria-describedby="" name="start_time"
                           class="form-control @error('start_time') is-invalid @enderror">
                </div>

                @error('start_time')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="">End Time</label>
                    <input type="datetime-local" id="" aria-describedby="" name="end_time"
                           class="form-control @error('end_time') is-invalid @enderror">
                </div>

                @error('end_time')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn bg-sidebar text-white" name="submit">Submit</button>
            </form>
        </form>
    </div>
@endsection
