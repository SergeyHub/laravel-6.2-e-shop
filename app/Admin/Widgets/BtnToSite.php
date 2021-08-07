<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Widgets\Widget;

class BtnToSite extends Widget
{
    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {

        return view('admin.widgets.to-site')->render();

    }

    /**
     * @return string|array
     */
    public function template()
    {
        return \AdminTemplate::getViewPath('_partials.header');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'navbar.right';
    }
}
