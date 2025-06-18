<?php

require_once dirname(__DIR__, 2) . "/config/bootstrap.php";

use App\Auth\LogoutUser;

LogoutUser::logout();