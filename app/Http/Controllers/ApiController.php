<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     host=L5_SWAGGER_CONST_HOST,
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *          @SWG\Info(
 *              title="Heroes Swagger",
 *              version="1.0",
 *              description="Swagger creates human-readable documentation for your APIs.",
 *              @SWG\Contact(name="Harley",email="harley@enclave.vn"),
 *              @SWG\License(name="Unlicense")
 *          ),
 *          @SWG\Definition(
 *              definition="Timestamps",
 *              @SWG\Property(
 *                  property="created_at",
 *                  type="string",
 *                  format="date-time",
 *                  description="Creation date",
 *                  example="2017-03-01 00:00:00"
 *              ),
 *              @SWG\Property(
 *                  property="updated_at",
 *                  type="string",
 *                  format="date-time",
 *                  description="Last updated",
 *                  example="2017-03-01 00:00:00"
 *              )
 *          )
 * )
 */
class ApiController extends Controller
{
    use ApiResponse;
}
