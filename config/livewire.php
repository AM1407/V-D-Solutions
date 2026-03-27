<?php

return [
    'temporary_file_upload' => [
        // Keep temporary uploads on local disk before media is persisted.
        'disk' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK', 'local'),
        // 12 MB default cap. Keep this image-only but avoid strict mime-list false negatives on JPG variants.
        'rules' => ['required', 'file', 'image', 'max:12288'],
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png',
            'gif',
            'bmp',
            'svg',
            'wav',
            'mp4',
            'mov',
            'avi',
            'wmv',
            'mp3',
            'm4a',
            'jpg',
            'jpeg',
            'mpga',
            'webp',
            'wma',
        ],
        'max_upload_time' => 5,
        'cleanup' => true,
    ],
];
