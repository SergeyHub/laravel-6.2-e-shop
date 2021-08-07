<?php

namespace App\Http\Admin\Display\Extensions;

use Illuminate\Contracts\Support\Renderable;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Display\Placable;
use SleepingOwl\Admin\Contracts\Display\DisplayExtensionInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Display;
use SleepingOwl\Admin\Display\Extension\Extension;


//
// ADD CUSTOM FILTER BUTTON\FIELDS SUPPORT IN TABLE HEADER
//

class DisplayFilterButtons extends Extension implements Initializable,Placable
{
    protected $placement = 'panel.heading';
    protected $view = 'display.extensions.displayfilter_buttons';

    protected $items = [];

    public function getPlacement()
    {
        return $this->placement;
    }

    public function set($items)
    {
        $this->items = $items;
        return $this->display;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getView()
    {
        return $this->view;
    }

    public function toArray()
    {
        return [
            'items' => $this->items,
            'placement' => $this->getPlacement(),
            ];
    }

    public function initialize()
    {
        // TODO: Implement initialize() method.
    }
}