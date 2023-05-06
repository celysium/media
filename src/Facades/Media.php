<?php
namespace Celysium\Media\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static upload(UploadedFile $file): ?string
 * @method static uploadViaUrl(string $url): ?string
 */
class Media extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'media-library';
    }
}
