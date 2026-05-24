<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRequestLogAPIRequest;
use App\Http\Requests\API\UpdateRequestLogAPIRequest;
use App\Models\RequestLog;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\RequestLogResource;
use Response;

/**
 * Class RequestLogController
 * @package App\Http\Controllers\API
 */

class RequestLogAPIController extends AppBaseController
{
    /**
     * Display a listing of the RequestLog.
     * GET|HEAD /requestLogs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = RequestLog::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $requestLogs = $query->get();

        return $this->sendResponse(RequestLogResource::collection($requestLogs), 'Request Logs retrieved successfully');
    }

    /**
     * Store a newly created RequestLog in storage.
     * POST /requestLogs
     *
     * @param CreateRequestLogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var RequestLog $requestLog */
        $requestLog = RequestLog::create($input);

        return $this->sendResponse(new RequestLogResource($requestLog), 'Request Log saved successfully');
    }

    /**
     * Display the specified RequestLog.
     * GET|HEAD /requestLogs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RequestLog $requestLog */
        $requestLog = RequestLog::find($id);

        if (empty($requestLog)) {
            return $this->sendError('Request Log not found');
        }

        return $this->sendResponse(new RequestLogResource($requestLog), 'Request Log retrieved successfully');
    }

    /**
     * Update the specified RequestLog in storage.
     * PUT/PATCH /requestLogs/{id}
     *
     * @param int $id
     * @param UpdateRequestLogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestLogAPIRequest $request)
    {
        /** @var RequestLog $requestLog */
        $requestLog = RequestLog::find($id);

        if (empty($requestLog)) {
            return $this->sendError('Request Log not found');
        }

        $requestLog->fill($request->all());
        $requestLog->save();

        return $this->sendResponse(new RequestLogResource($requestLog), 'RequestLog updated successfully');
    }

    /**
     * Remove the specified RequestLog from storage.
     * DELETE /requestLogs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RequestLog $requestLog */
        $requestLog = RequestLog::find($id);

        if (empty($requestLog)) {
            return $this->sendError('Request Log not found');
        }

        $requestLog->delete();

        return $this->sendSuccess('Request Log deleted successfully');
    }
}
