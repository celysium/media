<?php
namespace Celysium\MediaLibrary\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static upload(UploadedFile $file): ?string
 * @method static uploadViaUrl(string $url): ?string
 */
class MediaLibrary extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'media-library';
    }
}
