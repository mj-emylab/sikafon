<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCodeAPIRequest;
use App\Http\Requests\API\UpdateCodeAPIRequest;
use App\Models\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CodeResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Helper\Helpers;

/**
 * Class CodeController
 * @package App\Http\Controllers\API
 */

class CodeAPIController extends AppBaseController
{
    /**
     * Display a listing of the Code.
     * GET|HEAD /codes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Code::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $codes = $query->get();

        return $this->sendResponse(CodeResource::collection($codes), 'Codes retrieved successfully');
    }

    /**
     * Store a newly created Code in storage.
     * POST /codes
     *
     * @param CreateCodeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCodeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Code $code */
        $input['user_id'] = Auth::id();

        $codeGen = Helpers::generateVerificationCode();
        $qrCodeResult = Helpers::generateQRCode($codeGen);
        if (!$qrCodeResult['success']) {
            return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
        }
        
        $input['code'] = $codeGen;
        // $input['url'] = $qrCodeResult['file_path'];
        $input['url'] = "storage/codes/". basename($qrCodeResult['file_path']);

        $code = Code::create($input);

        return $this->sendResponse(new CodeResource($code), 'Code saved successfully');
    }

    /**
     * Display the specified Code.
     * GET|HEAD /codes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Code $code */
        $code = Code::find($id);

        if (empty($code)) {
            return $this->sendError('Code not found');
        }

        return $this->sendResponse(new CodeResource($code), 'Code retrieved successfully');
    }

    /**
     * Update the specified Code in storage.
     * PUT/PATCH /codes/{id}
     *
     * @param int $id
     * @param UpdateCodeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCodeAPIRequest $request)
    {
        /** @var Code $code */
        $code = Code::find($id);

        if (empty($code)) {
            return $this->sendError('Code not found');
        }

        $code->fill($request->all());
        $code->save();

        return $this->sendResponse(new CodeResource($code), 'Code updated successfully');
    }

    /**
     * Remove the specified Code from storage.
     * DELETE /codes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Code $code */
        $code = Code::find($id);

        if (empty($code)) {
            return $this->sendError('Code not found');
        }

        $code->delete();

        return $this->sendSuccess('Code deleted successfully');
    }
}
