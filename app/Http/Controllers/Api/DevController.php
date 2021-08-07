<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use SleepingOwl\Admin\Facades\Meta;

class DevController extends Controller
{
    function clearView()
    {
        if(access()->admin)
        {
            Artisan::call('view:clear');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }

    function clearCache()
    {
        if(access()->admin)
        {
            Artisan::call('cache:clear');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }

    function clearConfig()
    {
        if(access()->admin)
        {
            Artisan::call('config:clear');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }

    function clearRoute()
    {
        if(access()->admin)
        {
            Artisan::call('route:clear');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }

	 function optimize()
    {
        if(access()->admin)
        {
            Artisan::call('optimize');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }


    function migrate()
    {
        if(access()->admin)
        {
            Artisan::call('migrate');
            \MessagesStack::addSuccess('Команда выполнена: ' . Artisan::output());

        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }

    function checkSitemap()
    {
        Meta::addJs('sitemap-check.js', asset('/js/admin/sitemap-check.js'), ['admin-default']);
        Meta::addCss('spinner.css', asset('/css/admin/spinner.css'), ['admin-default']);
        $content = view("admin.dev.check-sitemap");
        return \AdminSection::view($content, 'Диагностика Sitemap.xml');
    }

	function toggleDevMode($state)
	{
		 session(['devmode'=>($state > 0)]);
		if ($state  > 0)
		{
			\MessagesStack::addSuccess('Режим разработчика включен');
		}
		else
		{
			\MessagesStack::addSuccess('Режим разработчика выключен');
		}
		return redirect('/admin');
	}
}
