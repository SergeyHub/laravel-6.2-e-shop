<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Facades\Meta;
use SleepingOwl\Admin\Widgets\Widget;

class Messages extends Widget
{
    public function __construct()
    {
        Meta::addCss('admin-messages.css', asset('/css/admin/widgets/admin-messages.css'), ['admin-default']);
        Meta::addJs('admin-messages.js', asset('/js/admin/widgets/admin-messages.js'), ['admin-default']);
        //
        Meta::addCss('spinner.css', asset('/css/admin/spinner.css'), ['admin-default']);
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {
            return view('admin.widgets.messages')->render();
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
