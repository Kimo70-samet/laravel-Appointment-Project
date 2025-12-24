@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>إدارة المستخدمين
                    </h4>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للوحة التحكم
                    </a>
                </div>
                <div class="card-body">
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

                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الدور</th>
                                        <th>الحالة</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <i class="fas fa-user text-primary me-2"></i>
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->isAdmin())
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-user-shield me-1"></i>مدير
                                                    </span>
                                                @else
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-user me-1"></i>مستخدم
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->isApproved())
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>مقبول
                                                    </span>
                                                @elseif($user->isPending())
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>في الانتظار
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>مرفوض
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($user->isPending())
                                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" title="قبول">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-warning" title="رفض" onclick="return confirm('هل أنت متأكد؟')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($user->isApproved())
                                                        @if(!$user->isAdmin())
                                                            <form method="POST" action="{{ route('admin.users.promote', $user) }}" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary" title="ترقية إلى مدير" onclick="return confirm('هل تريد ترقية هذا المستخدم إلى مدير؟')">
                                                                    <i class="fas fa-arrow-up"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('admin.users.demote', $user) }}" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-secondary" title="تخفيض إلى مستخدم" onclick="return confirm('هل تريد تخفيض رتبة هذا المدير؟')">
                                                                    <i class="fas fa-arrow-down"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users text-muted" style="font-size: 5rem;"></i>
                            <h3 class="text-muted mt-4">لا توجد مستخدمين</h3>
                            <p class="text-muted">لم يتم تسجيل أي مستخدمين جدد بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection