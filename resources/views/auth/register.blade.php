@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-3">إنشاء حساب جديد</h3>
                        <p class="text-muted">أدخل بياناتك لإنشاء حساب جديد</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>الاسم الكامل
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="أدخل اسمك الكامل">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                   placeholder="أدخل بريدك الإلكتروني">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>كلمة المرور
                                    </label>
                                    <input id="password" 
                                           type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="أدخل كلمة المرور">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password-confirm" class="form-label">
                                        <i class="fas fa-lock me-2"></i>تأكيد كلمة المرور
                                    </label>
                                    <input id="password-confirm" 
                                           type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="أعد إدخال كلمة المرور">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                            <i class="fas fa-user-plus me-2"></i>إنشاء الحساب
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-2">لديك حساب بالفعل؟</p>
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
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
