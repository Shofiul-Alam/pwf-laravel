<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\App;


class ApiController extends Controller
{
    use ApiResponser;

    public $imageRoot = "";

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function setImageRoot() {
        $this->imageRoot = isset($_ENV['APP_URL']) ? $_ENV['APP_URL'] : null;
    }
}
