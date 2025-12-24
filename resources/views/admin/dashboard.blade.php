@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Admin Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-4">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="fas fa-user-shield me-3"></i>
                        لوحة تحكم المدير
                    </h1>
                    <p class="lead">إدارة المستخدمين والصلاحيات</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-5">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h3>{{ $stats['total'] }}</h3>
                    <p>إجمالي المستخدمين</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-user-check fa-3x mb-3"></i>
                    <h3>{{ $stats['approved'] }}</h3>
                    <p>المستخدمين المقبولين</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-user-clock fa-3x mb-3"></i>
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>في انتظار الموافقة</p>
                </div>
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
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-users d-block mb-2" style="font-size: 2rem;"></i>
                                إدارة المستخدمين
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('appointments.index') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-calendar d-block mb-2" style="font-size: 2rem;"></i>
                                إدارة المواعيد
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('home') }}" class="btn btn-info w-100 py-3">
                                <i class="fas fa-home d-block mb-2" style="font-size: 2rem;"></i>
                                العودة للرئيسية
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Users -->
    @if($pendingUsers->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        المستخدمين في انتظار الموافقة ({{ $pendingUsers->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingUsers as $user)
                                <tr>
                                    <td>
                                        <i class="fas fa-user text-muted me-2"></i>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-1">
                                                <i class="fas fa-check"></i> قبول
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger me-1" onclick="return confirm('هل أنت متأكد من رفض هذا المستخدم؟')">
                                                <i class="fas fa-times"></i> رفض
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">لا توجد طلبات موافقة جديدة</h4>
                    <p class="text-muted">جميع المستخدمين تم قبولهم أو رفضهم</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection