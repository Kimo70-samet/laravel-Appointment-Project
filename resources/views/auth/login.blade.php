@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-lg-5 col-md-7">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-sign-in-alt text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-3">تسجيل الدخول</h3>
                        <p class="text-muted">أدخل بياناتك للوصول إلى حسابك</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>البريد الإلكتروني
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="أدخل بريدك الإلكتروني">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>كلمة المرور
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="أدخل كلمة المرور">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    تذكرني
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-2">ليس لديك حساب؟</p>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-2"></i>إنشاء حساب جديد
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
