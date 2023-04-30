<?php

namespace Celysium\MediaLibrary;

use Illuminate\Support\ServiceProvider;

class
MediaLibraryServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('media-library', function($app) {
            return new MediaLibrary();
        });
    }
}
