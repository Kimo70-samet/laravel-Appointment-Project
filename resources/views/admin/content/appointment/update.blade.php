@extends('admin.dashboard')

@section('content')
    <h4>Update Appointment</h4>
    <hr>

    <div>
        <form action="{{ route('appointment.update',$appointment->id) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('put')
            <form>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" id="" aria-describedby="" name="name"
                           class="form-control @error('name') is-invalid @enderror" value="{{ $appointment->name }}">
                </div>

                @error('name')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror
                <div class="form-group">
                <label for="">Start Time</label>
                <input type="datetime-local" id="" aria-describedby="" name="start_time"
                       class="form-control @error('start_time') is-invalid @enderror" value="{{ $appointment->start_time }}">
                </div>

                @error('start_time')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="">End Time</label>
                    <input type="datetime-local" id="" aria-describedby="" name="end_time"
                           class="form-control @error('end_time') is-invalid @enderror" value="{{ $appointment->end_time }}">
                </div>
                @error('end_time')
                <div class="alert alert-danger" style="margin-top: 10px">{{ $message }}</div>
                @enderror


                <button type="submit" class="btn bg-sidebar text-white" name="submit">Submit</button>
            </form>
        </form>
    </div>
@endsection
