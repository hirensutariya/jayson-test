<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

function getRolePermission($slug)
{
    $allPermission = User::with('role.rolePermission.singlePermission')->find(Auth::id());
    $data = [];
    if(isset($allPermission) && !empty($allPermission))
    {
        if(isset($allPermission->role) && $allPermission->role != null)
        {
            foreach($allPermission->role->rolePermission as $singlePermission)
            {
                ($singlePermission);
                $data[] = $singlePermission->singlePermission->slug;
            }
            if(isset($slug) && in_array($slug,$data)){
                return true;
            }else{
                return false;
            }
        }
    }
}
