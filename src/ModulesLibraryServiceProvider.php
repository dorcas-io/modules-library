<?php

namespace Dorcas\ModulesLibrary;
use Illuminate\Support\ServiceProvider;

class ModulesLibraryServiceProvider extends ServiceProvider {

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/resources/views', 'modules-library');
		$this->loadMigrationsFrom(__DIR__.'/migrations');
		$this->publishes([
			__DIR__.'/config/modules-library.php' => config_path('modules-library.php'),
		], 'dorcas-modules');
		/*$this->publishes([
			__DIR__.'/assets' => public_path('vendor/modules-library')
		], 'dorcas-modules');*/
	}

	public function register()
	{
		//add menu config
		$this->mergeConfigFrom(
			__DIR__.'/config/navigation-menu.php', 'navigation-menu.addons.sub-menu.modules-library.sub-menu'
		);
	}

}


?>