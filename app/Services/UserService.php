<?php

namespace App\Services;

class UserService{
    public static function getDashboardRouteBasedOnUserRole($userRole){
        if($userRole === 'user'){
            return route('user.dashboard.index');
        }

        if($userRole === 'admin'){
            return route('admin.dashboard.index');
        }
    }
}

?>
