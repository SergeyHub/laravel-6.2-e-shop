<?php


namespace App\Http\Admin;


use App\Http\Admin\Display\Extensions\DisplayFilterButtons;
use App\Http\Admin\Display\Extensions\DisplayFilterSelects;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

class History extends Section implements Initializable
{
    function initialize()
    {
        $this->title = "История изменений";
        $this->alias = "history";
        $this->icon = "fa fa-history";
    }

    protected $checkAccess = true;

    function can($action, Model $model)
    {
        return access()->admin;
    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables()
            ->setColumns([
                \AdminColumn::datetime("created_at", "Метка времени")->setSearchable(true)->setSearchable(false),
                \AdminColumn::text("user_name", "Пользователь")->setSearchable(false),
                \AdminColumn::custom("Действие", function ($instance) {
                    return $instance->label;
                })->setSearchable(false),
                \AdminColumn::lists("fields", "Поля"),
                \AdminColumn::custom("Подробнее", function ($instance) {
                    return '<a class="btn btn-info btn-xs" href="' . route("admin.history.show", ["history" => $instance->id]) . '"><i class="fa fa-eye" ></i> Просмотр</a>';
                })->setSearchable(false)
            ])
            ->setApply(function ($query) {
                $query->orderBy("id", "desc");
            })
            ->setDisplaySearch(true)
            ->paginate("50");
        //----------------------- Filters --------------------------
        $display->extend('display_filter_selects', new DisplayFilterSelects());
        $display->setDisplayFilterSelects([
            'model' => [
                "name" => "Объект",
                "options" => \App\Models\History::ModelsForFilter()
            ],
            'user' => [
                "name" => "Пользователь",
                "options" => \App\Models\History::UsersForFilter()
            ],
        ]);
        $display->setFilters([
            //
            \AdminDisplayFilter::custom('user')->setCallback(function ($query, $value) {
                if ($value != "*")
                    $query->where("user_id", $value);
            })->setTitle('Пользователь'),
            //
            \AdminDisplayFilter::custom('model')->setCallback(function ($query, $value) {
                if ($value != "*")
                    $query->where("model", $value);
            })->setTitle('Модель'),
            //
            \AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                if ($value != "*")
                    $query->where("model_id", $value);
            })->setTitle('ID'),
            //
        ]);
        //---------------------- END Filters -------------------------
        $display->getActions()->setView('display.actions.history_actions')->setPlacement('panel.buttons');
        return $display;
    }
}
