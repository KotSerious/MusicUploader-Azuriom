<?php

namespace Azuriom\Plugin\MusicUploader\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Illuminate\Support\Facades\Event;

class MusicUploaderServiceProvider extends BasePluginServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'musicuploader');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
		$this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'musicuploader');
		
		$this->registerAdminNavigation();

        Event::listen('theme.user-dropdown', function () {
            return [
                'name' => '🎵 ' . trans('musicuploader::messages.title'),
                'route' => 'musicuploader.index',
                'icon' => 'bi bi-music-note-list',
            ];
        });

        Permission::registerPermissions([
            'musicuploader.upload' => trans('musicuploader::messages.role'),
        ]);
    }
	
	    protected function adminNavigation(): array
    {
        return [
            'musicuploader' => [
                'name' => 'Music Uploader', 
                'icon' => 'bi bi-music-player', 
                'route' => 'musicuploader.admin.index', 
            ],
        ];
    }
}
