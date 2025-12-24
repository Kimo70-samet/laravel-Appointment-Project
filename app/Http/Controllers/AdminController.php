<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display admin dashboard
     */
    public function index(): View
    {
        $pendingUsers = User::pending()->get();
        $totalUsers = User::count();
        $approvedUsers = User::approved()->count();
        $pendingCount = User::pending()->count();

        $stats = [
            'total' => $totalUsers,
            'approved' => $approvedUsers,
            'pending' => $pendingCount,
        ];

        return view('admin.dashboard', compact('pendingUsers', 'stats'));
    }

    /**
     * Display all users for management
     */
    public function users(): View
    {
        $users = User::where('role', '!=', 'admin')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Approve user
     */
    public function approveUser(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'لا يمكن تعديل حساب المدير.');
        }

        $user->update(['status' => User::STATUS_APPROVED]);
        
        return back()->with('success', 'تم قبول المستخدم بنجاح.');
    }

    /**
     * Reject user
     */
    public function rejectUser(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'لا يمكن تعديل حساب المدير.');
        }

        $user->update(['status' => User::STATUS_REJECTED]);
        
        return back()->with('success', 'تم رفض المستخدم.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'لا يمكن حذف حساب المدير.');
        }

        $user->delete();
        
        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }

    /**
     * Promote user to admin
     */
    public function promoteUser(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'المستخدم مدير بالفعل.');
        }

        $user->update([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_APPROVED
        ]);
        
        return back()->with('success', 'تم ترقية المستخدم إلى مدير.');
    }

    /**
     * Demote admin to user
     */
    public function demoteUser(User $user): RedirectResponse
    {
        if (!$user->isAdmin()) {
            return back()->with('error', 'المستخدم ليس مديراً.');
        }

        // التأكد من وجود مدير آخر على الأقل
        $adminCount = User::where('role', User::ROLE_ADMIN)->count();
        if ($adminCount <= 1) {
            return back()->with('error', 'لا يمكن تخفيض رتبة المدير الوحيد.');
        }

        $user->update(['role' => User::ROLE_USER]);
        
        return back()->with('success', 'تم تخفيض رتبة المستخدم إلى مستخدم عادي.');
    }
}