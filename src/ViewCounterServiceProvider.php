<?php

namespace Craneplus\ViewCounter;

use Illuminate\Support\ServiceProvider;

class ViewCounterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      //$this->handleMigrations();
      $this->handleTranslations();
      $this->handleRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/Http/routes.php';
        $this->app->make('CounterPackage\ViewCounter\LikeController');
    }
    /**
   * Get the services provided by the provider.
   *
   * @return array
   */
    public function provides()
    {
        // Register events for view and like
        return array();
    }
    private function handleTranslations() {
        $this->loadTranslationsFrom('packagename', __DIR__.'/../src/lang');
    }
    /*private function handleViews() {
        $this->loadViewsFrom('packagename', __DIR__.'/../views');
        $this->publishes([
      __DIR__.'/../views' => base_path('resources/views/fraank/view-counter')
        ]);
    }*/
    private function handleRoutes() {
        include __DIR__.'/Http/routes.php';
    }
}
