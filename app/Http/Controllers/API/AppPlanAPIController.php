<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppPlanAPIRequest;
use App\Http\Requests\API\UpdateAppPlanAPIRequest;
use App\Models\AppPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppPlanResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AppPlanController
 * @package App\Http\Controllers\API
 */

class AppPlanAPIController extends AppBaseController
{
    /**
     * Display a listing of the AppPlan.
     * GET|HEAD /appPlans
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = AppPlan::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $appPlans = $query->get();

        return $this->sendResponse(AppPlanResource::collection($appPlans), 'App Plans retrieved successfully');
    }

    /**
     * Store a newly created AppPlan in storage.
     * POST /appPlans
     *
     * @param CreateAppPlanAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppPlanAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppPlan $appPlan */
        $input['user_id'] = Auth::id();
        $appPlan = AppPlan::create($input);

        return $this->sendResponse(new AppPlanResource($appPlan), 'App Plan saved successfully');
    }

    /**
     * Display the specified AppPlan.
     * GET|HEAD /appPlans/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppPlan $appPlan */
        $appPlan = AppPlan::find($id);

        if (empty($appPlan)) {
            return $this->sendError('App Plan not found');
        }

        return $this->sendResponse(new AppPlanResource($appPlan), 'App Plan retrieved successfully');
    }

    /**
     * Update the specified AppPlan in storage.
     * PUT/PATCH /appPlans/{id}
     *
     * @param int $id
     * @param UpdateAppPlanAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppPlanAPIRequest $request)
    {
        /** @var AppPlan $appPlan */
        $appPlan = AppPlan::find($id);

        if (empty($appPlan)) {
            return $this->sendError('App Plan not found');
        }

        $appPlan->fill($request->all());
        $appPlan->save();

        return $this->sendResponse(new AppPlanResource($appPlan), 'AppPlan updated successfully');
    }

    /**
     * Remove the specified AppPlan from storage.
     * DELETE /appPlans/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppPlan $appPlan */
        $appPlan = AppPlan::find($id);

        if (empty($appPlan)) {
            return $this->sendError('App Plan not found');
        }

        $appPlan->delete();

        return $this->sendSuccess('App Plan deleted successfully');
    }
}
