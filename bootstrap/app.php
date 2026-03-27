<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Log detailed diagnostics for Livewire upload failures to speed up debugging.
        $exceptions->report(function (Throwable $exception): void {
            if (! request()->is('livewire/*')) {
                return;
            }

            Log::error('Livewire upload request failed.', [
                'path' => request()->path(),
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
                'content_length' => request()->server('CONTENT_LENGTH'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
            ]);
        });

        $exceptions->report(function (PostTooLargeException $exception): void {
            Log::error('Upload rejected: request exceeded post_max_size.', [
                'path' => request()->path(),
                'content_length' => request()->server('CONTENT_LENGTH'),
                'post_max_size' => ini_get('post_max_size'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
            ]);
        });

        $exceptions->report(function (ValidationException $exception): void {
            if (! request()->is('livewire/*')) {
                return;
            }

            Log::warning('Livewire upload validation failed.', [
                'path' => request()->path(),
                'errors' => $exception->errors(),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]);
        });
    })->create();
