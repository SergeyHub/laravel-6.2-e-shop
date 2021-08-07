<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SleepingOwl\Admin\Facades\Meta;

class HistoryController extends Controller
{
    public function show(History $history)
    {
        Meta::addJs('compare.js', asset('/js/admin/compare.js'), ['admin-default']);

        $content = view("admin.history.instance")->with('instance',$history);
        return \AdminSection::view($content, '<i class="fa fa-history"></i> Действие #'.$history->id.' от '.$history->created_at);
    }
    public function clear()
    {
        if (access()->admin)
        {
            $now = Carbon::now();
            $month_before = $now->subDays(31);
            DB::table("history")->where("created_at", "<", $month_before)->delete();
            \MessagesStack::addSuccess("Удалены записи старше одного месяца");
        }
        else
        {
            \MessagesStack::addError("Недостаточно прав");
        }
        return back();
    }
}
