<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Constraint;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class OptimizeMediaOriginalToWebp
{
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->collection_name !== 'images') {
            return;
        }

        // Defer conversion until after the HTTP response to avoid blocking/stalling uploader UI state.
        app()->terminating(function () use ($media): void {
            $freshMedia = Media::query()->find($media->id);

            if (! $freshMedia) {
                return;
            }

            $this->optimizeMedia($freshMedia);
        });
    }

    private function optimizeMedia(Media $media): void
    {
        $tempSourcePath = null;
        $tempWebpPath = null;

        try {
            $disk = Storage::disk($media->disk);
            $originalRelativePath = $media->getPathRelativeToRoot();

            if (strtolower(pathinfo($originalRelativePath, PATHINFO_EXTENSION)) === 'webp') {
                return;
            }

            $sourceContents = $disk->get($originalRelativePath);

            if ($sourceContents === null) {
                throw new \RuntimeException("Could not read media file for optimization: {$originalRelativePath}");
            }

            $sourceExtension = pathinfo($originalRelativePath, PATHINFO_EXTENSION) ?: 'img';
            $tempSourcePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('media-src-', true).'.'.$sourceExtension;
            $tempWebpPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('media-webp-', true).'.webp';

            if (file_put_contents($tempSourcePath, '') === false || file_put_contents($tempWebpPath, '') === false) {
                throw new \RuntimeException('Could not allocate temporary files for media optimization.');
            }

            file_put_contents($tempSourcePath, $sourceContents);

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
                throw new \RuntimeException('Could not read temporary optimized media output.');
            }

            if (strlen($optimizedContents) === 0) {
                throw new \RuntimeException('Optimized WebP output is empty.');
            }

            $optimizedImageInfo = @getimagesizefromstring($optimizedContents);

            if (! is_array($optimizedImageInfo) || ($optimizedImageInfo['mime'] ?? null) !== 'image/webp') {
                throw new \RuntimeException('Optimized output is not a valid WebP image.');
            }

            $disk->put($newRelativePath, $optimizedContents);

            if ($newRelativePath !== $originalRelativePath) {
                $disk->delete($originalRelativePath);
            }

            $newSize = $disk->size($newRelativePath);
            $newMimeType = $disk->mimeType($newRelativePath) ?: 'image/webp';

            $media->forceFill([
                'file_name' => $newFileName,
                'mime_type' => $newMimeType,
                'size' => $newSize,
            ])->save();
        } catch (Throwable $exception) {
            Log::warning('Media WebP optimization skipped; keeping original upload.', [
                'media_id' => $media->id,
                'disk' => $media->disk,
                'collection' => $media->collection_name,
                'exception' => $exception->getMessage(),
            ]);
        } finally {
            if (is_string($tempSourcePath) && file_exists($tempSourcePath)) {
                unlink($tempSourcePath);
            }

            if (is_string($tempWebpPath) && file_exists($tempWebpPath)) {
                unlink($tempWebpPath);
            }
        }
    }
}
