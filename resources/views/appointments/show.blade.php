@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>تفاصيل الموعد
                    </h4>
                    <div>
                        @if($appointment->start_time > now())
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-clock me-1"></i>قادم
                            </span>
                        @elseif($appointment->end_time < now())
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-check me-1"></i>منتهي
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-play me-1"></i>جاري الآن
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary">
                                    <i class="fas fa-tag me-2"></i>اسم الموعد
                                </h5>
                                <p class="fs-4 fw-bold">{{ $appointment->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-info">
                                    <i class="fas fa-user me-2"></i>منشئ الموعد
                                </h5>
                                <p class="fs-5">
                                    {{ $appointment->user->name ?? 'غير محدد' }}
                                    @if($appointment->user && $appointment->user->isAdmin())
                                        <span class="badge bg-danger ms-2">مدير</span>
                                    @else
                                        <span class="badge bg-info ms-2">مستخدم</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-info">
                                    <i class="fas fa-clock me-2"></i>مدة الموعد
                                </h5>
                                <p class="fs-5">
                                    <span class="badge bg-info fs-6">{{ $appointment->duration }} دقيقة</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-success">
                                        <i class="fas fa-play me-2"></i>تاريخ ووقت البداية
                                    </h5>
                                    <p class="fs-5 fw-bold">{{ $appointment->start_time->format('Y-m-d') }}</p>
                                    <p class="fs-4 text-success">{{ $appointment->start_time->format('H:i') }}</p>
                                    <small class="text-muted">
                                        {{ $appointment->start_time->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-danger">
                                        <i class="fas fa-stop me-2"></i>تاريخ ووقت النهاية
                                    </h5>
                                    <p class="fs-5 fw-bold">{{ $appointment->end_time->format('Y-m-d') }}</p>
                                    <p class="fs-4 text-danger">{{ $appointment->end_time->format('H:i') }}</p>
                                    <small class="text-muted">
                                        {{ $appointment->end_time->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle me-2"></i>معلومات إضافية
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>تاريخ الإنشاء:</strong><br>
                                            {{ $appointment->created_at->format('Y-m-d H:i') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>آخر تحديث:</strong><br>
                                            {{ $appointment->updated_at->format('Y-m-d H:i') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>هل هو اليوم؟</strong><br>
                                            @if($appointment->is_today)
                                                <span class="badge bg-warning">نعم</span>
                                            @else
                                                <span class="badge bg-light text-dark">لا</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                        </a>
                        <div>
                            @if(Auth::user()->canManageAppointment($appointment))
                                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-2"></i>تعديل
                                </a>
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>حذف
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection