<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TaskController extends BaseController
{
    public function getIndex($param): string
    {
        var_dump($param);
        return view("teste");
    }
}
