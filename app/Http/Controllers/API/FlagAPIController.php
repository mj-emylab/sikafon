<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFlagAPIRequest;
use App\Http\Requests\API\UpdateFlagAPIRequest;
use App\Models\Flag;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FlagResource;
use Response;

/**
 * Class FlagController
 * @package App\Http\Controllers\API
 */

class FlagAPIController extends AppBaseController
{
    /**
     * Display a listing of the Flag.
     * GET|HEAD /flags
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Flag::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $flags = $query->get();

        return $this->sendResponse(FlagResource::collection($flags), 'Flags retrieved successfully');
    }

    /**
     * Store a newly created Flag in storage.
     * POST /flags
     *
     * @param CreateFlagAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFlagAPIRequest $request)
    {
        $input = $request->all();

        /** @var Flag $flag */
        $input['user_id'] = Auth::id();
        $flag = Flag::create($input);

        return $this->sendResponse(new FlagResource($flag), 'Flag saved successfully');
    }

    /**
     * Display the specified Flag.
     * GET|HEAD /flags/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Flag $flag */
        $flag = Flag::find($id);

        if (empty($flag)) {
            return $this->sendError('Flag not found');
        }

        return $this->sendResponse(new FlagResource($flag), 'Flag retrieved successfully');
    }

    /**
     * Update the specified Flag in storage.
     * PUT/PATCH /flags/{id}
     *
     * @param int $id
     * @param UpdateFlagAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFlagAPIRequest $request)
    {
        /** @var Flag $flag */
        $flag = Flag::find($id);

        if (empty($flag)) {
            return $this->sendError('Flag not found');
        }

        $flag->fill($request->all());
        $flag->save();

        return $this->sendResponse(new FlagResource($flag), 'Flag updated successfully');
    }

    /**
     * Remove the specified Flag from storage.
     * DELETE /flags/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Flag $flag */
        $flag = Flag::find($id);

        if (empty($flag)) {
            return $this->sendError('Flag not found');
        }

        $flag->delete();

        return $this->sendSuccess('Flag deleted successfully');
    }
}
