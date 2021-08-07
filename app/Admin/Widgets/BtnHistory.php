<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Widgets\Widget;

class BtnHistory extends Widget
{
    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {

        return access()->content ? view('admin.widgets.journal')->render() : null;

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
