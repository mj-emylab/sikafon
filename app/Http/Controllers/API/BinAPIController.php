<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBinAPIRequest;
use App\Http\Requests\API\UpdateBinAPIRequest;
use App\Models\Bin;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BinResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class BinController
 * @package App\Http\Controllers\API
 */

class BinAPIController extends AppBaseController
{
    /**
     * Display a listing of the Bin.
     * GET|HEAD /bins
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Bin::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $bins = $query->get();

        return $this->sendResponse(BinResource::collection($bins), 'Bins retrieved successfully');
    }

    /**
     * Store a newly created Bin in storage.
     * POST /bins
     *
     * @param CreateBinAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBinAPIRequest $request)
    {
        $input = $request->all();

        /** @var Bin $bin */
        $input['user_id'] = Auth::id();
        $bin = Bin::create($input);

        return $this->sendResponse(new BinResource($bin), 'Bin saved successfully');
    }

    /**
     * Display the specified Bin.
     * GET|HEAD /bins/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Bin $bin */
        $bin = Bin::find($id);

        if (empty($bin)) {
            return $this->sendError('Bin not found');
        }

        return $this->sendResponse(new BinResource($bin), 'Bin retrieved successfully');
    }

    /**
     * Update the specified Bin in storage.
     * PUT/PATCH /bins/{id}
     *
     * @param int $id
     * @param UpdateBinAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBinAPIRequest $request)
    {
        /** @var Bin $bin */
        $bin = Bin::find($id);

        if (empty($bin)) {
            return $this->sendError('Bin not found');
        }

        $bin->fill($request->all());
        $bin->save();

        return $this->sendResponse(new BinResource($bin), 'Bin updated successfully');
    }

    /**
     * Remove the specified Bin from storage.
     * DELETE /bins/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Bin $bin */
        $bin = Bin::find($id);

        if (empty($bin)) {
            return $this->sendError('Bin not found');
        }

        $bin->delete();

        return $this->sendSuccess('Bin deleted successfully');
    }
}
