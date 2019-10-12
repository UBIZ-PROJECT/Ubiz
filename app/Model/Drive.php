<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class Drive
{
    public function getData($page = 0, $sort = '', $search = '')
    {
        try {
            return [];
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
