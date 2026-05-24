<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContactAPIRequest;
use App\Http\Requests\API\UpdateContactAPIRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ContactResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ContactController
 * @package App\Http\Controllers\API
 */

class ContactAPIController extends AppBaseController
{
    /**
     * Display a listing of the Contact.
     * GET|HEAD /contacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $contacts = $query->get();

        return $this->sendResponse(ContactResource::collection($contacts), 'Contacts retrieved successfully');
    }

    /**
     * Store a newly created Contact in storage.
     * POST /contacts
     *
     * @param CreateContactAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateContactAPIRequest $request)
    {
        $input = $request->all();

        /** @var Contact $contact */
        $input['user_id'] = Auth::id();
        $contact = Contact::create($input);

        return $this->sendResponse(new ContactResource($contact), 'Contact saved successfully');
    }

    /**
     * Display the specified Contact.
     * GET|HEAD /contacts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Contact $contact */
        $contact = Contact::find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        return $this->sendResponse(new ContactResource($contact), 'Contact retrieved successfully');
    }

    /**
     * Update the specified Contact in storage.
     * PUT/PATCH /contacts/{id}
     *
     * @param int $id
     * @param UpdateContactAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactAPIRequest $request)
    {
        /** @var Contact $contact */
        $contact = Contact::find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact->fill($request->all());
        $contact->save();

        return $this->sendResponse(new ContactResource($contact), 'Contact updated successfully');
    }

    /**
     * Remove the specified Contact from storage.
     * DELETE /contacts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Contact $contact */
        $contact = Contact::find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact->delete();

        return $this->sendSuccess('Contact deleted successfully');
    }
}
