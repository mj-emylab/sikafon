<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppPlanUserAPIRequest;
use App\Http\Requests\API\UpdateAppPlanUserAPIRequest;
use App\Models\AppPlanUser;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppPlanUserResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AppPlanUserController
 * @package App\Http\Controllers\API
 */

class AppPlanUserAPIController extends AppBaseController
{
    /**
     * Display a listing of the AppPlanUser.
     * GET|HEAD /appPlanUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = AppPlanUser::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $appPlanUsers = $query->get();

        return $this->sendResponse(AppPlanUserResource::collection($appPlanUsers), 'App Plan Users retrieved successfully');
    }

    /**
     * Store a newly created AppPlanUser in storage.
     * POST /appPlanUsers
     *
     * @param CreateAppPlanUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppPlanUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppPlanUser $appPlanUser */
        $input['user_id'] = Auth::id();
        $appPlanUser = AppPlanUser::create($input);

        return $this->sendResponse(new AppPlanUserResource($appPlanUser), 'App Plan User saved successfully');
    }

    /**
     * Display the specified AppPlanUser.
     * GET|HEAD /appPlanUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppPlanUser $appPlanUser */
        $appPlanUser = AppPlanUser::find($id);

        if (empty($appPlanUser)) {
            return $this->sendError('App Plan User not found');
        }

        return $this->sendResponse(new AppPlanUserResource($appPlanUser), 'App Plan User retrieved successfully');
    }

    /**
     * Update the specified AppPlanUser in storage.
     * PUT/PATCH /appPlanUsers/{id}
     *
     * @param int $id
     * @param UpdateAppPlanUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppPlanUserAPIRequest $request)
    {
        /** @var AppPlanUser $appPlanUser */
        $appPlanUser = AppPlanUser::find($id);

        if (empty($appPlanUser)) {
            return $this->sendError('App Plan User not found');
        }

        $appPlanUser->fill($request->all());
        $appPlanUser->save();

        return $this->sendResponse(new AppPlanUserResource($appPlanUser), 'AppPlanUser updated successfully');
    }

    /**
     * Remove the specified AppPlanUser from storage.
     * DELETE /appPlanUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppPlanUser $appPlanUser */
        $appPlanUser = AppPlanUser::find($id);

        if (empty($appPlanUser)) {
            return $this->sendError('App Plan User not found');
        }

        $appPlanUser->delete();

        return $this->sendSuccess('App Plan User deleted successfully');
    }
}
