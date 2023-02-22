<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReplaceRequest;
use App\Services\ReplaceService;

class ReplaceController extends Controller
{
    private $service;

    public function __construct(ReplaceService $service)
    {
        $this->service = $service;
    }

    public function index(ReplaceRequest $request)
    {
        $savePdfPath = $this->service->replace($request);

        return response()
        ->download($savePdfPath)
        ->deleteFileAfterSend(true);
    }
}
