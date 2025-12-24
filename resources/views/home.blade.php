@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="display-5 fw-bold text-primary mb-3">
                        <i class="fas fa-home me-3"></i>
                        مرحباً بك، {{ Auth::user()->name }}!
                        @if(Auth::user()->isAdmin())
                            <span class="badge bg-danger ms-2">مدير</span>
                        @endif
                    </h1>
                    <p class="lead text-muted">إدارة مواعيدك بكل سهولة وفعالية</p>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->isAdmin())
        @php
            $pendingUsersCount = App\Models\User::pending()->count();
        @endphp
        @if($pendingUsersCount > 0)
            <!-- Admin Alert for Pending Users -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تنبيه للمدير:</strong> يوجد {{ $pendingUsersCount }} مستخدم في انتظار الموافقة.
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-warning ms-3">
                            <i class="fas fa-eye me-1"></i>عرض الطلبات
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card">
                <i class="fas fa-calendar-check"></i>
                <h3 class="fw-bold">{{ $stats['total'] ?? 0 }}</h3>
                <p class="mb-0">إجمالي المواعيد</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);">
                <i class="fas fa-clock"></i>
                <h3 class="fw-bold">{{ $stats['upcoming'] ?? 0 }}</h3>
                <p class="mb-0">المواعيد القادمة</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-calendar-day"></i>
                <h3 class="fw-bold">{{ $stats['today'] ?? 0 }}</h3>
                <p class="mb-0">مواعيد اليوم</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>إجراءات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-plus-circle d-block mb-2" style="font-size: 2rem;"></i>
                                إضافة موعد جديد
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('appointments.index') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-list d-block mb-2" style="font-size: 2rem;"></i>
                                عرض جميع المواعيد
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('appointments.calendar') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-calendar-alt d-block mb-2" style="font-size: 2rem;"></i>
                                عرض التقويم
                            </a>
                        </div>
                        @if(Auth::user()->isAdmin())
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-danger w-100 py-3">
                                    <i class="fas fa-user-shield d-block mb-2" style="font-size: 2rem;"></i>
                                    لوحة تحكم المدير
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.users') }}" class="btn btn-dark w-100 py-3">
                                    <i class="fas fa-users d-block mb-2" style="font-size: 2rem;"></i>
                                    إدارة المستخدمين
                                </a>
                            </div>
                        @else
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('appointments.index') }}?filter=upcoming" class="btn btn-info w-100 py-3">
                                    <i class="fas fa-clock d-block mb-2" style="font-size: 2rem;"></i>
                                    المواعيد القادمة
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>المواعيد الأخيرة
                    </h5>
                    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">
                        عرض الكل
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentAppointments) && $recentAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>اسم الموعد</th>
                                        <th>تاريخ البداية</th>
                                        <th>تاريخ النهاية</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAppointments as $appointment)
                                        <tr>
                                            <td>
                                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                                {{ $appointment->name }}
                                            </td>
                                            <td>
                                                <i class="fas fa-clock text-muted me-1"></i>
                                                {{ $appointment->start_time->format('Y-m-d H:i') }}
                                            </td>
                                            <td>
                                                <i class="fas fa-clock text-muted me-1"></i>
                                                {{ $appointment->end_time->format('Y-m-d H:i') }}
                                            </td>
                                            <td>
                                                @if($appointment->start_time > now())
                                                    <span class="badge bg-success">قادم</span>
                                                @elseif($appointment->end_time < now())
                                                    <span class="badge bg-secondary">منتهي</span>
                                                @else
                                                    <span class="badge bg-warning">جاري</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(Auth::user()->canManageAppointment($appointment))
                                                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">لا توجد مواعيد حتى الآن</h4>
                            <p class="text-muted">ابدأ بإضافة موعدك الأول</p>
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>إضافة موعد جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection