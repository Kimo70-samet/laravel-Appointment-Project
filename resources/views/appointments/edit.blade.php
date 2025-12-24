@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل الموعد: {{ $appointment->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-2"></i>اسم الموعد
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $appointment->name) }}" 
                                   placeholder="أدخل اسم الموعد"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="start_time" class="form-label">
                                        <i class="fas fa-play text-success me-2"></i>تاريخ ووقت البداية
                                    </label>
                                    <input type="datetime-local" 
                                           class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" 
                                           name="start_time" 
                                           value="{{ old('start_time', $appointment->start_time->format('Y-m-d\TH:i')) }}"
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="end_time" class="form-label">
                                        <i class="fas fa-stop text-danger me-2"></i>تاريخ ووقت النهاية
                                    </label>
                                    <input type="datetime-local" 
                                           class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" 
                                           name="end_time" 
                                           value="{{ old('end_time', $appointment->end_time->format('Y-m-d\TH:i')) }}"
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Current Duration Display -->
                        <div class="mb-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>المدة الحالية: </strong>{{ $appointment->duration }} دقيقة
                            </div>
                        </div>

                        <!-- New Duration Display -->
                        <div class="mb-4">
                            <div class="alert alert-success" id="duration-display" style="display: none;">
                                <i class="fas fa-clock me-2"></i>
                                <strong>المدة الجديدة: </strong><span id="duration-text"></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <div>
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info me-2">
                                    <i class="fas fa-eye me-2"></i>عرض
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function calculateDuration() {
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();
        
        if (startTime && endTime) {
            const start = new Date(startTime);
            const end = new Date(endTime);
            
            if (end > start) {
                const diffMs = end - start;
                const diffMins = Math.floor(diffMs / 60000);
                const hours = Math.floor(diffMins / 60);
                const minutes = diffMins % 60;
                
                let durationText = '';
                if (hours > 0) {
                    durationText += hours + ' ساعة ';
                }
                if (minutes > 0) {
                    durationText += minutes + ' دقيقة';
                }
                
                $('#duration-text').text(durationText);
                $('#duration-display').show();
            } else {
                $('#duration-display').hide();
            }
        } else {
            $('#duration-display').hide();
        }
    }
    
    $('#start_time, #end_time').on('change', calculateDuration);
    
    // Calculate initial duration
    calculateDuration();
});
</script>
@endpush