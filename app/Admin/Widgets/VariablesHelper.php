<?php


namespace App\Admin\Widgets;


use SleepingOwl\Admin\Facades\Meta;
use SleepingOwl\Admin\Widgets\Widget;

class VariablesHelper extends Widget
{
    public function __construct()
    {
        Meta::addCss('variables-helper.css', asset('/css/admin/widgets/variables-helper.css'), ['admin-default']);
        Meta::addJs('variables-helper.js', asset('/js/admin/widgets/variables-helper.js'), ['admin-default']);
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {

        return access()->content ? view('admin.widgets.text-variables')->render() : null;

    }

    /**
     * @return string|array
     */
    public function template()
    {
        return \AdminTemplate::getViewPath('_layout.base');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'footer-scripts';
    }
}
