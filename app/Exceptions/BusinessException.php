<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BusinessException extends Exception
{
    public function __construct(
        string $message = 'Thao tác vi phạm quy định nghiệp vụ.',
        int $code = 400,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
            ], $this->getCode() >= 400 && $this->getCode() < 600 ? $this->getCode() : 400);
        }

        return back()->with('error', $this->getMessage())->withInput();
    }
}
