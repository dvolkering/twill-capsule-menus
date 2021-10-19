<?php


namespace App\Twill\Capsules\Menus;


use App\Twill\Capsules\Menus\Http\Middleware\Menu;
use App\Twill\Capsules\Menus\Models\MenuItem;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Relation::morphMap([
            'menus' => Menu::class,
            'menu_items' => MenuItem::class
        ]);
    }
    public function register()
    {
        $this->app['router']->aliasMiddleware('menu', Menu::class);
    }
}
