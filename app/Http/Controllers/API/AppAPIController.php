<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppAPIRequest;
use App\Http\Requests\API\UpdateAppAPIRequest;
use App\Models\App;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;
use App\Models\Code;

/**
 * Class AppController
 * @package App\Http\Controllers\API
 */

class AppAPIController extends AppBaseController
{
    /**
     * Display a listing of the App.
     * GET|HEAD /apps
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = App::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $apps = $query->get();

        return $this->sendResponse(AppResource::collection($apps), 'Apps retrieved successfully');
    }

    /**
     * Store a newly created App in storage.
     * POST /apps
     *
     * @param CreateAppAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppAPIRequest $request)
    {
        $input = $request->all();

        $code = Helpers::generateVerificationCode();
        $qrCodeResult = Helpers::generateAndDecodeQRCode($code);
        if (!$qrCodeResult['success']) {
            return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
        }
        $input['user_id'] = Auth::id();
        $input['code_id'] = $code->id;
        $input['qrcode_id'] = $code->id;

        $image = Helpers::getImageUrlFromStorage($request, 'image', 'apps');
        if($image) {
            $input['url'] = $image;
        } else {
            unset($input['url']);
        }

        $app = App::create($input);

        $code = new Code();
        $code->user_id = Auth::id();
        $code->code = $code;
        $code->url = $qrCodeResult['file_path'];
        $code->codeable_type = 'App\Models\App';
        $code->codeable_id = $app->id;
        $code->save();

        return $this->sendResponse(new AppResource($app), 'App saved successfully');
    }

    /**
     * Display the specified App.
     * GET|HEAD /apps/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var App $app */
        $app = App::find($id);

        if (empty($app)) {
            return $this->sendError('App not found');
        }

        return $this->sendResponse(new AppResource($app), 'App retrieved successfully');
    }

    /**
     * Update the specified App in storage.
     * PUT/PATCH /apps/{id}
     *
     * @param int $id
     * @param UpdateAppAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppAPIRequest $request)
    {
        /** @var App $app */
        $app = App::find($id);

        if (empty($app)) {
            return $this->sendError('App not found');
        }

        $app->fill($request->all());
        $app->save();

        return $this->sendResponse(new AppResource($app), 'App updated successfully');
    }

    /**
     * Remove the specified App from storage.
     * DELETE /apps/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var App $app */
        $app = App::find($id);

        if (empty($app)) {
            return $this->sendError('App not found');
        }

        $app->delete();

        return $this->sendSuccess('App deleted successfully');
    }
}
