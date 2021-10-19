<?php

namespace App\Twill\Capsules\Menus\Http\Controllers;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Twill\Capsules\Menus\Http\Requests\MenuItemRequest;
use App\Twill\Capsules\Menus\Repositories\MenuItemRepository;
use Illuminate\Support\Facades\Route;

class MenuItemController extends ModuleController
{
    protected $moduleName = 'menuItems';


    protected $indexOptions = [
        'reorder' => true,
    ];

    protected function indexData($request)
    {
        return [
            'nested' => true,
            'nestedDepth' => 2, // this controls the allowed depth in UI
        ];
    }

    protected function transformIndexItems($items)
    {
        return $items->toTree();
    }

    protected function indexItemData($item)
    {
        return ($item->children ? [
            'children' => $this->getIndexTableData($item->children),
        ] : []);
    }

    public function formData($request)
    {
        $options = [
            [
                'value' => '',
                'label' =>  'Select Item',
            ],
            /*[
                'value' => 'pages.index',
                'label' => 'Page listing'
            ]*/
        ];

        return [
            'routes' => $options
        ];
    }

    public function getRepositoryClass($model)
    {
        return MenuItemRepository::class;
    }

    public function getFormRequestClass()
    {
        return MenuItemRequest::class;
    }

    protected function getViewPrefix() {
        return 'Menus.resources.views.admin.MenuItems';
    }
}
