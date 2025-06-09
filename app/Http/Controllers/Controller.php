<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Clase base para todos los controladores del proyecto.
 * Proporciona validación y autorización de solicitudes.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
