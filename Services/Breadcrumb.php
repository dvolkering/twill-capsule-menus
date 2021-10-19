<?php


namespace App\Twill\Capsules\Menus\Services;

use App\Twill\Capsules\Menus\Models\MenuItem;
use Illuminate\Support\Collection;

class Breadcrumb
{
    /**
     * generate breadcrumb for current MenuItem
     * @param MenuItem $menuItem
     * @return Collection
     */
    public function make(MenuItem $menuItem)
    {
        $breadcrumb = collect([]);
        $menuItem->ancestors->each(function($parent) use($breadcrumb) {
            $data = [
                'label' => $parent->title,
                'url' => ''
            ];

            //resolving internal item
            $item = $this->resolvedPage($parent);

            //if the parent is not an internal item try to resolve route
            if(!$item) {
                $url = $this->resolvedRoute($parent);
                $data['url'] = $url;
            }else {
                $data['url'] = property_exists($item,'url') ? $item->url() : '/'.$item->getTable().'/'.$item->getSlug();
            }


            $breadcrumb->push($data);

        });

        $breadcrumb->push([
            'label' => $menuItem->title,
            'url' => ''
        ]);


        return $breadcrumb;
    }

    protected function resolvedRoute($parent)
    {
        if($parent->route_path) {
            return route($parent->route_path). $parent->params;
        }

        return null;
    }

    protected function resolvedPage($parent)
    {
        $item = $parent->relatedItems()->first();

        if(!$item) {
            $item = $parent->children()->first() ? $parent->children()->first()->relatedItems()->first() : null;
        }


        if($item) {
            $subject = $item->subject;
            $item = $subject->getRelated('related_menu')->first();
        }

        return $item;
    }

}
