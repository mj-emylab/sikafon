<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGalleryAPIRequest;
use App\Http\Requests\API\UpdateGalleryAPIRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\GalleryResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class GalleryController
 * @package App\Http\Controllers\API
 */

class GalleryAPIController extends AppBaseController
{
    /**
     * Display a listing of the Gallery.
     * GET|HEAD /galleries
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $galleries = $query->get();

        return $this->sendResponse(GalleryResource::collection($galleries), 'Galleries retrieved successfully');
    }

    /**
     * Store a newly created Gallery in storage.
     * POST /galleries
     *
     * @param CreateGalleryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateGalleryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Gallery $gallery */
        $input['user_id'] = Auth::id();
        $gallery = Gallery::create($input);

        return $this->sendResponse(new GalleryResource($gallery), 'Gallery saved successfully');
    }

    /**
     * Display the specified Gallery.
     * GET|HEAD /galleries/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Gallery $gallery */
        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return $this->sendError('Gallery not found');
        }

        return $this->sendResponse(new GalleryResource($gallery), 'Gallery retrieved successfully');
    }

    /**
     * Update the specified Gallery in storage.
     * PUT/PATCH /galleries/{id}
     *
     * @param int $id
     * @param UpdateGalleryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGalleryAPIRequest $request)
    {
        /** @var Gallery $gallery */
        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return $this->sendError('Gallery not found');
        }

        $gallery->fill($request->all());
        $gallery->save();

        return $this->sendResponse(new GalleryResource($gallery), 'Gallery updated successfully');
    }

    /**
     * Remove the specified Gallery from storage.
     * DELETE /galleries/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Gallery $gallery */
        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return $this->sendError('Gallery not found');
        }

        $gallery->delete();

        return $this->sendSuccess('Gallery deleted successfully');
    }
}
