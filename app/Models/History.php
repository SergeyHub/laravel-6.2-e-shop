<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = "history";

    protected $casts = [
        "new" => "array",
        "old" => "array",
        "fields" => "array",
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fields = [];
        $this->old = [];
        $this->new = [];
    }

    //--------------------- PUBLIC METHODS -------------------//
    public static function ModelCreate($model)
    {
        $model = $model[0];
        if (get_class($model) != History::class) {
            $history = new History();
            $history->arregate($model);
            $history->fields = array_keys($model->attributes);
            $history->new = $model->attributes;
            $history->type = "create";
            $history->user_id = access()->id;
            $history->save();

        }
        return true;
    }

    public static function ModelUpdate($model)
    {
        $model = $model[0];
        if (get_class($model) != History::class) {
            $history = new History();
            $history->arregate($model);
            if ($history->deltas($model)) {
                $history->type = "update";
                $history->user_id = access()->id;
                $history->save();
            }

        }
        return true;
    }

    public static function ModelDelete($model)
    {
        $model = $model[0];
        if (get_class($model) != History::class) {
            $history = new History();
            $history->arregate($model);
            $history->fields = array_keys($model->attributes);
            $history->old = $model->attributes;
            $history->type = "delete";
            $history->user_id = access()->id;
            $history->save();
        }
        return true;
    }


    public static function ModelsForFilter()
    {
        $options = [];
        $options = ["*"=>"Все объекты"];
        foreach (config("history-aliases.models") as $model=>$item)
        {
            $options[$model] = $item['name'];
        }
        return $options;
    }

    public static function UsersForFilter()
    {
        $options = [];
        $options = ["*"=>"Все пользователи"];
        foreach (User::all() as $user)
        {
            $options[$user->id] = $user->name;
        }
        return $options;
    }
    //-----------------------------------------------------//

    private function arregate($model)
    {

        $this->model = get_class($model);
        $this->model_id = $model->id;
    }

    private function deltas($model)
    {
        $model_old = get_class($model)::find($model->id);
        $fields = [];
        $old = [];
        $new = [];
        $same = true;
        foreach ($model_old->attributes as $key => $value) {

            if ($key != "created_at" &&  $value != ($model->attributes[$key] ?? null)) {
                $fields[] = $key;
                $old[$key] = $value;
                $new[$key] = $model->attributes[$key] ?? null;
                $same = false;
            }
        }
        $this->fields = $fields;
        $this->old = $old;
        $this->new = $new;
        return !$same;
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function getTypeNameAttribute()
    {
        return config("history-aliases.types." . $this->type.".name") ?? $this->type;
    }

    function getTypeIconAttribute()
    {
        return config("history-aliases.types." . $this->type.".icon") ?? "fa cogs";
    }

    function getModelNameAttribute()
    {
        return config("history-aliases.models." . $this->model.".name") ?? $this->model;
    }

    function getModelIconAttribute()
    {
        return config("history-aliases.models." . $this->model.".icon") ?? "fa cogs";
    }

    function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : "Не указан (API)";
    }

    function getModelEditLinkAttribute()
    {
        $model = $this->model;
        $id = $this->model_id;
        if (!class_exists($model))
        {
            return null;
        }
        $instance = $model::find($id);
        if (is_null($instance))
        {
            return null;
        }
        if (config("history-aliases.models.".$model.".edit")  === false)
        {
            return null;
        }
        return "/admin/".$instance->getTable()."/".$id."/edit";
    }

    function getLabelAttribute()
    {
        switch ($this->type)
        {
            case "create":
                return view("admin.history.table.create",["instance"=>$this])->render();
                break;
            case "update":
                return view("admin.history.table.update",["instance"=>$this])->render();
                break;
            case "delete":
                return view("admin.history.table.delete",["instance"=>$this])->render();
                break;
            default:
                return view("admin.history.table.default",["instance"=>$this])->render();
        }

    }
}
