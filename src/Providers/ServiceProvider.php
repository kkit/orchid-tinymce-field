<?php

declare(strict_types=1);

namespace kkit\OrchidTinyMCEField\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @const string
     */
    const PACKAGE_NAME = 'orchid-tinymce-field';

    /**
     * @const string
     */
    const PACKAGE_PATH = __DIR__ . '/../../';

    /**
     * @var Dashboard
     */
    protected Dashboard $dashboard;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $this->loadViewsFrom(self::PACKAGE_PATH . 'resources/views',
            self::PACKAGE_NAME);

        $this->registerResources();

        $this->publishes([
            self::PACKAGE_PATH . 'resources/views' => resource_path('views/vendor/'.self::PACKAGE_NAME)
        ]);
    }

    /**
     * @return $this
     */
    protected function registerResources(): self
    {
        $this->publishes([
            __DIR__.'/../../../public' => public_path('vendor/orchid-tinymce-field'),
        ], ['orchid-tinymce-field-assets', 'laravel-assets']);

        View::composer('platform::app', function () {
            $this->dashboard
                //->registerResource('scripts', 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.6/tinymce.min.js')
                ->registerResource('scripts', mix('/js/orchid_tinymce_field.js', self::PACKAGE_NAME));
        });

        return $this;
    }
}
