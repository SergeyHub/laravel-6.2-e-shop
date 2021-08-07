<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Facades\Meta;
use SleepingOwl\Admin\Widgets\Widget;

class TinyPNGStatus extends Widget
{
    public function __construct()
    {
        Meta::addJs('tiny-png.js', asset('/js/admin/widgets/tiny-png.js'), ['admin-default']);
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {

            return access()->content ?  view('admin.widgets.tiny-png')->render() : null;
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
