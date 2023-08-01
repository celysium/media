<?php

namespace Celysium\Media;

use Celysium\Request\Exceptions\BadRequestHttpException;
use Celysium\Request\Facades\RequestBuilder;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class Media
{
    /**
     * @param UploadedFile $file
     * @return string|null
     * @throws BadRequestHttpException
     */
    public function upload(UploadedFile $file): ?string
    {
        return RequestBuilder::request()
            ->attach('file', $file->getContent(), $file->getClientOriginalName())
            ->post('internal/v1/media/files')
            ->onError(fn($response) => throw new BadRequestHttpException($response))
            ->json('data.path');
    }

    /**
     * @param string $url
     * @return string|null
     * @throws BadRequestHttpException
     * @throws ValidationException
     */
    public function uploadByUrl(string $url): ?string
    {
        if (trim($url) == '') {
            throw ValidationException::withMessages(['url' => ['url is required.']]);
        }

        return RequestBuilder::request()
            ->timeout(5)
            ->retry(5)
            ->post('internal/v1/media/files/url', [
                'url' => $url
            ])
            ->onError(fn($response) => throw new BadRequestHttpException($response))
            ->json('data.path');
    }

    /**
     * @param string $content
     * @param string $extension
     * @return string|null
     * @throws BadRequestHttpException
     * @throws ValidationException
     */
    public function uploadByContent(string $content, string $extension): ?string
    {
        if (empty($extension)) {
            throw ValidationException::withMessages(['extension' => ['extension is required.']]);
        }

        if (empty($content)) {
            throw ValidationException::withMessages(['content' => ['content is required.']]);
        }

        if ($extension == 'json' && empty(json_decode($content))) {
            throw ValidationException::withMessages(['content' => ['content is invalid.']]);
        }

        return RequestBuilder::request()
            ->post('internal/v1/media/files/content', compact('content', 'extension'))
            ->onError(fn($response) => throw new BadRequestHttpException($response))
            ->json('data.path');
    }
}
