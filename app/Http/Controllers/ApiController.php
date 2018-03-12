<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="localhost:8000",
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="This is my website cool API",
 *         description="Api description...",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="contact@mysite.com"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http..."
 *     )
 * )
 */

class ApiController extends Controller
{
    use ApiResponse;
}
