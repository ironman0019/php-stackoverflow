<?php

namespace Activities\Admin;

use Activities\Auth\Auth;

class Admin {

    public function __construct()
    {
        $auth = new Auth();
        $auth->checkAdmin();
    }

}