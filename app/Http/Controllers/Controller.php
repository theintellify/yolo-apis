<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 *	@OA\Info(
 *		version="1.0.0",
 *		title="Yolo API",
 *		description="Yolo API",
 *	)
 *	@OA\Server(
 *		url=OA_BASEURL_API,
 *	),
 *	@OA\SecurityScheme(
 *		securityScheme="bearerAuth",
 *		type="http",
 *		scheme="bearer",
 *	),
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
