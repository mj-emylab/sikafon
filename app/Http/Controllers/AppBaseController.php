<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   schemes={"http","https"},
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   ),
 *   @SWG\SecurityScheme(
 *     securityDefinition="Bearer",
 *     type="apiKey",
 *     name="Authorization",
 *     in="header"  *   ),
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    // all error response function
    public function errorResponse($data, $status)
    {
        return response()->json([
            'status' => $status,
            'message' => $data
        ], $status);
    }

    // all data response function
    public function successResponse($data, $status)
    {
        return response()->json([
            'status' => $status,
            'success' => true,
            'data' => $data
        ], $status);
    }

    public function serverError(Exception $e)
    {
        logger($e->getMessage());
        logger($e->getTraceAsString());
        return $this->errorResponse(config('app.debug') ? $e->getMessage() : __('misc.server_error'),
                    Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
