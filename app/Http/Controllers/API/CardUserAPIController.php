<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCardUserAPIRequest;
use App\Http\Requests\API\UpdateCardUserAPIRequest;
use App\Models\CardUser;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CardUserResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class CardUserController
 * @package App\Http\Controllers\API
 */

class CardUserAPIController extends AppBaseController
{
    /**
     * Display a listing of the CardUser.
     * GET|HEAD /cardUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = CardUser::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $cardUsers = $query->get();

        return $this->sendResponse(CardUserResource::collection($cardUsers), 'Card Users retrieved successfully');
    }

    /**
     * Store a newly created CardUser in storage.
     * POST /cardUsers
     *
     * @param CreateCardUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCardUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var CardUser $cardUser */
        $input['user_id'] = Auth::id();
        $cardUser = CardUser::create($input);

        return $this->sendResponse(new CardUserResource($cardUser), 'Card User saved successfully');
    }

    /**
     * Display the specified CardUser.
     * GET|HEAD /cardUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CardUser $cardUser */
        $cardUser = CardUser::find($id);

        if (empty($cardUser)) {
            return $this->sendError('Card User not found');
        }

        return $this->sendResponse(new CardUserResource($cardUser), 'Card User retrieved successfully');
    }

    /**
     * Update the specified CardUser in storage.
     * PUT/PATCH /cardUsers/{id}
     *
     * @param int $id
     * @param UpdateCardUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCardUserAPIRequest $request)
    {
        /** @var CardUser $cardUser */
        $cardUser = CardUser::find($id);

        if (empty($cardUser)) {
            return $this->sendError('Card User not found');
        }

        $cardUser->fill($request->all());
        $cardUser->save();

        return $this->sendResponse(new CardUserResource($cardUser), 'CardUser updated successfully');
    }

    /**
     * Remove the specified CardUser from storage.
     * DELETE /cardUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CardUser $cardUser */
        $cardUser = CardUser::find($id);

        if (empty($cardUser)) {
            return $this->sendError('Card User not found');
        }

        $cardUser->delete();

        return $this->sendSuccess('Card User deleted successfully');
    }
}
