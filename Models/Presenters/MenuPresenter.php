<?php
namespace App\Twill\Capsules\Menus\Models\Presenters;

class MenuPresenter
{
    protected $entity; // This is to store the original model instance

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    // Call the function if that exists, or return the property on the original model
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }
        return $this->entity->{$property};
    }

    public function menuItemsLink() {

        return '<a href="'.route('admin.menus.menuItems.index', [
            'menu_id' => $this->id
            ]).'" class="button buttonInList">See Items</a>';

    }

}
