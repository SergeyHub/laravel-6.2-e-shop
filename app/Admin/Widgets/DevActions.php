<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Widgets\Widget;

class DevActions extends Widget
{
    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {

        return access()->admin ? view('admin.widgets.devmode')->render() : null;

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
