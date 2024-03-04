<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    use HttpResponse;

    public function index(Request $request)
    {
        return $this->response('Lista de usuários', 200, User::all());
    }

}
