<?php

namespace Celysium\Media;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('media-library', function($app) {
            return new Media();
        });
    }
}
