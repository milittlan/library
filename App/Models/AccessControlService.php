<?php

namespace App\Models;

class AccessControlService extends \Core\Model   {

    public function checkAccess ($modulemachinename, $permission) {

    }

    public static function isLoggedIn () {
        return isset($_SESSION['id']);
    }

}