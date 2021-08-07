<?php

namespace App\Providers;

use App\Admin\Widgets\BtnHistory;
use App\Admin\Widgets\BtnToSite;
use App\Admin\Widgets\DevActions;
use App\Admin\Widgets\Messages;
use App\Admin\Widgets\QuickActions;
use App\Admin\Widgets\TinyPNGStatus;
use App\Admin\Widgets\VariablesHelper;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use App\Admin\Widgets\NavigationUserBlock;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;

class AdminSectionsServiceProvider extends ServiceProvider
{
    protected $widgets = [
        DevActions::class,
        VariablesHelper::class,
        BtnHistory::class,
        Messages::class,
        BtnToSite::class,
        NavigationUserBlock::class,
    ];
    /**
     * @var array
     */
    protected $sections = [
        //\App\Models\User::class => 'App\Http\Sections\Users',
        \App\Models\Order::class => 'App\Http\Admin\Order',
        \App\Models\Review::class => 'App\Http\Admin\Review',
        \App\Models\Callback::class => 'App\Http\Admin\Callback',
        \App\Models\Country::class => 'App\Http\Admin\Country',
        \App\Models\City::class => 'App\Http\Admin\Cities',
        \App\Models\Page::class => 'App\Http\Admin\Pages',
        \App\Models\Category::class => 'App\Http\Admin\Category',
        \App\Models\Set::class => 'App\Http\Admin\Set',
        //\App\Models\Brand::class => 'App\Http\Admin\Brand',
        \App\Models\Product::class => 'App\Http\Admin\Product',
        \App\Models\Block::class => 'App\Http\Admin\Block',
        \App\Models\Video::class => 'App\Http\Admin\Video',
        \App\Models\Config::class => 'App\Http\Admin\Config',
        \App\Models\Blog::class => 'App\Http\Admin\Blog',
        \App\Models\News::class => 'App\Http\Admin\News',
        \App\Models\Promo::class => 'App\Http\Admin\Promo',
        \App\Models\Comment::class => 'App\Http\Admin\Comment',
        \App\Models\Review::class => 'App\Http\Admin\Review',
        \App\Models\Correct::class => 'App\Http\Admin\Correct',
        \App\Models\Meta::class => 'App\Http\Admin\Meta',
        \App\Models\Question::class => 'App\Http\Admin\Question',
        \App\Models\Member::class => 'App\Http\Admin\Member',
        \App\Models\User::class => 'App\Http\Admin\User',
        \App\Models\History::class => 'App\Http\Admin\History',

        \App\Models\Filter::class => 'App\Http\Admin\Filter',
        \App\Models\FilterGroup::class => 'App\Http\Admin\FilterGroup',
        //------------------------- DEVELOPER MODE SECTIONS -------------------------
        \App\Models\Dev\Block::class=> 'App\Http\Admin\Dev\Block',
        \App\Models\Dev\Meta::class => 'App\Http\Admin\Dev\Meta',
        \App\Models\Dev\Page::class => 'App\Http\Admin\Dev\Pages',
        \App\Models\Dev\Config::class => 'App\Http\Admin\Dev\Config',
        \App\Models\Dev\Country::class => 'App\Http\Admin\Dev\Country'
        //---------------------------------------------------------------------------
    ];


    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
        $widgetsRegistry = $this->app[\SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface::class];

        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }

        //register new form elements
        $formElementContainer = app('sleeping_owl.form.element');
        $formElementContainer->add('imagesWithFlags', \App\Http\Admin\Form\Element\ImagesWithFlags::class);
        $formElementContainer->add('JSON', \App\Http\Admin\Form\Element\Json::class);
        $formElementContainer->add('multiselectTabled', \App\Http\Admin\Form\Element\MultiSelectTabled::class);
        $formElementContainer->add('prices', \App\Http\Admin\Form\Element\Prices::class);
        $formElementContainer->add('filters', \App\Http\Admin\Form\Element\Filters::class);

        //register new column types
        $columnContainer = app('sleeping_owl.table.column');
        $columnContainer->add('main',\App\Http\Admin\Column\Main::class);
    }
}
