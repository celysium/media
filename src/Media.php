<?php

namespace Celysium\Media;

use Celysium\Request\Exceptions\BadRequestHttpException;
use Exception;
use Illuminate\Http\UploadedFile;
use Celysium\Request\Facades\RequestBuilder;

class Media
{
    /**
     * @param UploadedFile $file
     * @return string
     * @throws BadRequestHttpException
     */
    public function upload(UploadedFile $file): string
    {
        return RequestBuilder::request()
            ->attach('file', $file->getContent(), $file->getClientOriginalName())
            ->post('/v1/media/files')
            ->onError(fn($response) => throw new BadRequestHttpException($response))
            ->json('data.path');
    }

    /**
     * @param string $url
     * @return string
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function uploadByUrl(string $url): string
    {
        if (trim($url) == '') {
            throw new Exception("url is empty.");
        }

        return RequestBuilder::request()
            ->timeout(5)
            ->retry(5)
            ->post('v1/media/files/url', [
                'url' => $url
            ])
            ->onError(fn($response) => throw new BadRequestHttpException($response))
            ->json('data.path');
    }
}
