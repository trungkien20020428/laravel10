<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class exampleAPI extends Controller
{
    public bool $success;
    public int $code;

    public function __construct(
        bool $success = true,
        int $code = 200
    ) {
        $this->success = $success;
        $this->code = $code;
        $this->middleware('auth:api');
    }

    public function success(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        $result = User::query()->find(1);

        return response([
            'success' => $this->success,
            'code' => $this->code,
            'result' => $result,
        ], $this->code);
    }

    public function error(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        return response([
            'success' => false,
            'code' => 400,
        ], Response::HTTP_BAD_REQUEST);
    }
}
