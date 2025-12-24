@extends('layouts.simple')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 fw-bold text-primary mb-4">
                        <i class="fas fa-home me-3"></i>
                        مرحباً بك، {{ Auth::user()->name }}!
                    </h1>
                    <p class="lead text-muted mb-4">مرحباً بك في نظام إدارة المواعيد</p>
                    
                    <div class="row mt-5">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-check fa-3x mb-3"></i>
                                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                                    <p>إجمالي المواعيد</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-3x mb-3"></i>
                                    <h3>{{ $stats['upcoming'] ?? 0 }}</h3>
                                    <p>المواعيد القادمة</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-day fa-3x mb-3"></i>
                                    <h3>{{ $stats['today'] ?? 0 }}</h3>
                                    <p>مواعيد اليوم</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-plus fa-3x mb-3"></i>
                                    <h3><a href="{{ route('appointments.create') }}" class="text-white text-decoration-none">إضافة</a></h3>
                                    <p>موعد جديد</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('appointments.index') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-list me-2"></i>عرض جميع المواعيد
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('appointments.calendar') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-calendar-alt me-2"></i>عرض التقويم
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('appointments.create') }}" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-plus me-2"></i>إضافة موعد جديد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection