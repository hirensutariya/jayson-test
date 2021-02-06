<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //$userId = Auth::user()->load('role.rolePermission.permission');
//        dd( User::find(Auth::id())->role->rolePermission->first()->permissions->first()->slug );
//        dd( User::find(Auth::id())->role->rolePermission->permissions );
        //$allPermission = User::with('role.rolePermission.permissions')->find(Auth::id());
        //$allPermissionArray = $allPermission->toArray();
        //dd($allPermissionArray['role']['role_permission'][0]['permissions'][0]['slug']);
        return $next($request);
    }
}
