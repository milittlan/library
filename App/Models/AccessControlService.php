<?php

namespace App\Models;

class AccessControlService extends \Core\Model   {

    public function checkAccess ($modulemachinename, $permission) {

    }

    public static function isLoggedIn () {
        
        $user =  isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

        if ($user) {
            return true;
        }

        return false;

    }

}