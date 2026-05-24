<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLogAPIRequest;
use App\Http\Requests\API\UpdateLogAPIRequest;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LogResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class LogController
 * @package App\Http\Controllers\API
 */

class LogAPIController extends AppBaseController
{
    /**
     * Display a listing of the Log.
     * GET|HEAD /logs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Log::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $logs = $query->get();

        return $this->sendResponse(LogResource::collection($logs), 'Logs retrieved successfully');
    }

    /**
     * Store a newly created Log in storage.
     * POST /logs
     *
     * @param CreateLogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var Log $log */
        $input['user_id'] = Auth::id();
        $log = Log::create($input);

        return $this->sendResponse(new LogResource($log), 'Log saved successfully');
    }

    /**
     * Display the specified Log.
     * GET|HEAD /logs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        return $this->sendResponse(new LogResource($log), 'Log retrieved successfully');
    }

    /**
     * Update the specified Log in storage.
     * PUT/PATCH /logs/{id}
     *
     * @param int $id
     * @param UpdateLogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLogAPIRequest $request)
    {
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        $log->fill($request->all());
        $log->save();

        return $this->sendResponse(new LogResource($log), 'Log updated successfully');
    }

    /**
     * Remove the specified Log from storage.
     * DELETE /logs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        $log->delete();

        return $this->sendSuccess('Log deleted successfully');
    }
}
