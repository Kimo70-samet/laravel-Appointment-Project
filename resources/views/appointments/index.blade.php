@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>إدارة المواعيد
                    </h4>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>إضافة موعد جديد
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter Buttons -->
                    <div class="mb-4">
                        <div class="btn-group" role="group">
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary {{ !request('filter') ? 'active' : '' }}">
                                <i class="fas fa-list me-1"></i>جميع المواعيد
                            </a>
                            <a href="{{ route('appointments.index', ['filter' => 'upcoming']) }}" class="btn btn-outline-success {{ request('filter') == 'upcoming' ? 'active' : '' }}">
                                <i class="fas fa-clock me-1"></i>القادمة
                            </a>
                            <a href="{{ route('appointments.index', ['filter' => 'past']) }}" class="btn btn-outline-secondary {{ request('filter') == 'past' ? 'active' : '' }}">
                                <i class="fas fa-history me-1"></i>المنتهية
                            </a>
                            <a href="{{ route('appointments.index', ['filter' => 'today']) }}" class="btn btn-outline-warning {{ request('filter') == 'today' ? 'active' : '' }}">
                                <i class="fas fa-calendar-day me-1"></i>اليوم
                            </a>
                        </div>
                    </div>

                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموعد</th>
                                        <th>المنشئ</th>
                                        <th>تاريخ البداية</th>
                                        <th>تاريخ النهاية</th>
                                        <th>المدة</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                                <strong>{{ $appointment->name }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-user text-info me-2"></i>
                                                {{ $appointment->user->name ?? 'غير محدد' }}
                                                @if($appointment->user && $appointment->user->isAdmin())
                                                    <span class="badge bg-danger ms-1">مدير</span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-play text-success me-1"></i>
                                                {{ $appointment->start_time->format('Y-m-d') }}<br>
                                                <small class="text-muted">{{ $appointment->start_time->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <i class="fas fa-stop text-danger me-1"></i>
                                                {{ $appointment->end_time->format('Y-m-d') }}<br>
                                                <small class="text-muted">{{ $appointment->end_time->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $appointment->duration }} دقيقة
                                                </span>
                                            </td>
                                            <td>
                                                @if($appointment->start_time > now())
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-clock me-1"></i>قادم
                                                    </span>
                                                @elseif($appointment->end_time < now())
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-check me-1"></i>منتهي
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-play me-1"></i>جاري
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(Auth::user()->canManageAppointment($appointment))
                                                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $appointments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times text-muted" style="font-size: 5rem;"></i>
                            <h3 class="text-muted mt-4">لا توجد مواعيد</h3>
                            <p class="text-muted">لم يتم العثور على أي مواعيد بالمعايير المحددة</p>
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">
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