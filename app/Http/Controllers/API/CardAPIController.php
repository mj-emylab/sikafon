<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCardAPIRequest;
use App\Http\Requests\API\UpdateCardAPIRequest;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CardResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class CardController
 * @package App\Http\Controllers\API
 */

class CardAPIController extends AppBaseController
{
    /**
     * Display a listing of the Card.
     * GET|HEAD /cards
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Card::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $cards = $query->get();

        return $this->sendResponse(CardResource::collection($cards), 'Cards retrieved successfully');
    }

    /**
     * Store a newly created Card in storage.
     * POST /cards
     *
     * @param CreateCardAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCardAPIRequest $request)
    {
        $input = $request->all();

        /** @var Card $card */
        $input['user_id'] = Auth::id();
        $card = Card::create($input);

        return $this->sendResponse(new CardResource($card), 'Card saved successfully');
    }

    /**
     * Display the specified Card.
     * GET|HEAD /cards/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Card $card */
        $card = Card::find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        return $this->sendResponse(new CardResource($card), 'Card retrieved successfully');
    }

    /**
     * Update the specified Card in storage.
     * PUT/PATCH /cards/{id}
     *
     * @param int $id
     * @param UpdateCardAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCardAPIRequest $request)
    {
        /** @var Card $card */
        $card = Card::find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        $card->fill($request->all());
        $card->save();

        return $this->sendResponse(new CardResource($card), 'Card updated successfully');
    }

    /**
     * Remove the specified Card from storage.
     * DELETE /cards/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Card $card */
        $card = Card::find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        $card->delete();

        return $this->sendSuccess('Card deleted successfully');
    }
}
