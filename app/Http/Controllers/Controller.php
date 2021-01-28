<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0",
 *      title="Github Search repositories",
 *      description="simple service searching in github repositories",
 *      @OA\Contact(
 *          name="ibrahimsaeed",
 *          email="c.ibrahimsaeed@gmail.com",
 *          url="https://www.linkedin.com/in/developer-ibrahim-saeed/"),
 *      ),
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
