<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function get() {
        $clients = User::where('account_type', 'client');

        return response()->json($clients->get());
    }
}
