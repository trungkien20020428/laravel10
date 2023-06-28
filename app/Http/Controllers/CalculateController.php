<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CalculateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function execute(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->validateRequest($request);
        $this->validateDivisionByZero($request);

        $a = $request->a;
        $b = $request->b;
        $operator = $request->operator ?? '+';

        $amount = match ($operator) {
            '+' => $a + $b,
            '-' => $a - $b,
            '*' => $a * $b,
            '/' => $a / $b,
            default => 0,
        };

        return response([
            'success' => true,
            'amount' => $amount,
        ]);
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'a' => 'required',
            'operator' => 'nullable|in:+,-,*,/',
            'b' => 'required',
        ]);

        $request->validate([
            'a' => 'required|numeric',
            'operator' => 'nullable|in:+,-,*,/',
            'b' => 'required|numeric',
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function validateDivisionByZero(Request $request): void
    {
        if (0 === (int) $request->b && '/' === $request->operator) {
            throw ValidationException::withMessages(['b' => 'Error division by zero']);
        }
    }
}
