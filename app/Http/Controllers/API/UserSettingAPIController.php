<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserSettingAPIRequest;
use App\Http\Requests\API\UpdateUserSettingAPIRequest;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserSettingResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class UserSettingController
 * @package App\Http\Controllers\API
 */

class UserSettingAPIController extends AppBaseController
{
    /**
     * Display a listing of the UserSetting.
     * GET|HEAD /userSettings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = UserSetting::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $userSettings = $query->get();

        return $this->sendResponse(UserSettingResource::collection($userSettings), 'User Settings retrieved successfully');
    }

    /**
     * Store a newly created UserSetting in storage.
     * POST /userSettings
     *
     * @param CreateUserSettingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserSettingAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserSetting $userSetting */
        $input['user_id'] = Auth::id();
        $userSetting = UserSetting::create($input);

        return $this->sendResponse(new UserSettingResource($userSetting), 'User Setting saved successfully');
    }

    /**
     * Display the specified UserSetting.
     * GET|HEAD /userSettings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserSetting $userSetting */
        $userSetting = UserSetting::find($id);

        if (empty($userSetting)) {
            return $this->sendError('User Setting not found');
        }

        return $this->sendResponse(new UserSettingResource($userSetting), 'User Setting retrieved successfully');
    }

    /**
     * Update the specified UserSetting in storage.
     * PUT/PATCH /userSettings/{id}
     *
     * @param int $id
     * @param UpdateUserSettingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserSettingAPIRequest $request)
    {
        /** @var UserSetting $userSetting */
        $userSetting = UserSetting::find($id);

        if (empty($userSetting)) {
            return $this->sendError('User Setting not found');
        }

        $userSetting->fill($request->all());
        $userSetting->save();

        return $this->sendResponse(new UserSettingResource($userSetting), 'UserSetting updated successfully');
    }

    /**
     * Remove the specified UserSetting from storage.
     * DELETE /userSettings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserSetting $userSetting */
        $userSetting = UserSetting::find($id);

        if (empty($userSetting)) {
            return $this->sendError('User Setting not found');
        }

        $userSetting->delete();

        return $this->sendSuccess('User Setting deleted successfully');
    }
}
