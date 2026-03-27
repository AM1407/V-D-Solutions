<?php

namespace App\Listeners;

use RuntimeException;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Constraint;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class OptimizeMediaOriginalToWebp
{
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->collection_name !== 'images') {
            return;
        }

        $disk = Storage::disk($media->disk);
        $originalRelativePath = $media->getPathRelativeToRoot();
        $sourceContents = $disk->get($originalRelativePath);

        if ($sourceContents === null) {
            throw new RuntimeException("Could not read media file for optimization: {$originalRelativePath}");
        }

        $tempSourcePath = tempnam(sys_get_temp_dir(), 'media-src-');
        $tempWebpPath = tempnam(sys_get_temp_dir(), 'media-webp-');

        if ($tempSourcePath === false || $tempWebpPath === false) {
            throw new RuntimeException('Could not allocate temporary files for media optimization.');
        }

        file_put_contents($tempSourcePath, $sourceContents);

        // Re-encode the original upload itself to WebP and clamp max dimensions.
        Image::load($tempSourcePath)
            ->width(1920, [Constraint::PreserveAspectRatio, Constraint::DoNotUpsize])
            ->height(1920, [Constraint::PreserveAspectRatio, Constraint::DoNotUpsize])
            ->quality(80)
            ->format('webp')
            ->save($tempWebpPath);

        $newRelativePath = preg_replace('/\.[^.]+$/', '.webp', $originalRelativePath) ?? ($originalRelativePath.'.webp');
        $newFileName = pathinfo($media->file_name, PATHINFO_FILENAME).'.webp';

        $optimizedContents = file_get_contents($tempWebpPath);

        if ($optimizedContents === false) {
            throw new RuntimeException('Could not read temporary optimized media output.');
        }

        $disk->put($newRelativePath, $optimizedContents);

        if ($newRelativePath !== $originalRelativePath) {
            $disk->delete($originalRelativePath);
        }

        if (file_exists($tempSourcePath)) {
            unlink($tempSourcePath);
        }

        if (file_exists($tempWebpPath)) {
            unlink($tempWebpPath);
        }

        $newSize = $disk->size($newRelativePath);
        $newMimeType = $disk->mimeType($newRelativePath) ?: 'image/webp';

        $media->forceFill([
            'file_name' => $newFileName,
            'mime_type' => $newMimeType,
            'size' => $newSize,
        ])->save();
    }
}
