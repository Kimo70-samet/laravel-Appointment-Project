@extends('layouts.app')

@section('content')
<div class="welcome-hero">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">
            <i class="fas fa-calendar-check me-3"></i>
            نظام إدارة المواعيد
        </h1>
        <p class="lead mb-4">نظام متطور وحديث لإدارة المواعيد بكفاءة وسهولة</p>
        @guest
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-user-plus me-2"></i>إنشاء حساب جديد
                </a>
            </div>
        @else
            <a href="{{ route('home') }}" class="btn btn-light btn-lg px-4">
                <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
            </a>
        @endguest
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-calendar-plus"></i>
                <h4 class="fw-bold">إضافة المواعيد</h4>
                <p class="text-muted">أضف مواعيدك بسهولة مع تحديد التاريخ والوقت المناسب</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-calendar-alt"></i>
                <h4 class="fw-bold">عرض التقويم</h4>
                <p class="text-muted">اعرض جميع مواعيدك في تقويم تفاعلي وسهل الاستخدام</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-bell"></i>
                <h4 class="fw-bold">التنبيهات</h4>
                <p class="text-muted">احصل على تنبيهات للمواعيد القادمة لتكون دائماً في الموعد</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-edit"></i>
                <h4 class="fw-bold">تعديل المواعيد</h4>
                <p class="text-muted">عدل مواعيدك بسهولة في أي وقت تشاء</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-chart-bar"></i>
                <h4 class="fw-bold">الإحصائيات</h4>
                <p class="text-muted">تابع إحصائيات مواعيدك وأدائك بشكل مفصل</p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <i class="fas fa-mobile-alt"></i>
                <h4 class="fw-bold">متوافق مع الجوال</h4>
                <p class="text-muted">استخدم النظام من أي جهاز بتصميم متجاوب</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">لماذا تختار نظامنا؟</h2>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>سهولة الاستخدام:</strong> واجهة بسيطة ومفهومة
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>الأمان:</strong> حماية عالية لبياناتك
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>السرعة:</strong> أداء سريع وموثوق
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>التحديث المستمر:</strong> ميزات جديدة باستمرار
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-rocket" style="font-size: 8rem; color: #667eea; opacity: 0.7;"></i>
            </div>
        </div>
    </div>
</div>
@endsection