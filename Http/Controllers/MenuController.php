<?php

namespace App\Twill\Capsules\Menus\Http\Controllers;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class MenuController extends ModuleController
{
    protected $moduleName = 'menus';

    protected $indexOptions = [
        'editInModal' => true,
    ];

    protected $indexColumns = [
        'title' => [ // field column
            'title' => 'Title',
            'field' => 'title',
        ],
        'menuItemsLink' => [ // field column
            'title' => 'See Items',
            'field' => 'menuItemsLink',
            'present' => true
        ]
    ];

}
