<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;

class ResetController extends Controller
{
    public function reset() {

        Artisan::call('migrate:fresh');
        return 'OK';
    }
}
