<?php

namespace Celysium\MediaLibrary;

use Exception;
use Illuminate\Http\UploadedFile;
use Celysium\Request\Facades\RequestBuilder;

class MediaLibrary
{
    public function upload(UploadedFile $file): ?string
    {
        return RequestBuilder::request()
            ->attach(
                'file', $file->getContent(), $file->getClientOriginalName())
            ->post('/media/files')
            ->json('data.path');
    }

    public function uploadViaUrl(string $url): ?string
    {
        if (trim($url) == '')
            return null;

        return RequestBuilder::request()
            ->timeout(1)
            ->retry(5)
            ->post('/media/files/by-url', [
                'url' => $url
            ])
            ->json('data.path');
    }
}
