<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $casts = [
        "values"=>"array",
    ];

    protected $guarded = [
        "_token"
    ];

    //============= SCOPES ==============//

    //Важные
    public function scopeProblems($query)
    {
        return $query->orderBy("created_at","desc")->where("type","problem")->orWhere("type","bug");
    }

    //Заметки
    public function scopeNotes($query)
    {
        return $query->orderBy("created_at","desc")->where("type","note");
    }

    //Остальные
    public function scopeAny($query)
    {
        return $query->orderBy("created_at","desc")->orderBy('type')->where("type","<>","note")->where("type","<>","problem")->where("type","<>","bug");
    }

    //От пользователя
    public function scopeUser($query, $user_id)
    {
        return  $query->where("user_id",$user_id)->orderBy("created_at","desc");
    }

    //По типу
    public function scopeType($query, $type)
    {
        return  $query->where("type",$type)->orderBy("created_at","desc");
    }

    //Последние N сообщений
    public function scopeLast($query, $count = 5)
    {
        return $query->orderBy("created_at","desc")->take($count);
    }

    //По модели/секции/объекту
    public function scopeModel($query, $model, $id = 0)
    {
        if ($model instanceof Model)
        {
            $model_path = $model->getTable();
            $id = $model->id;
            return $query->where("model",$model_path)->where("model_id",$id)->orderBy("created_at","desc");
        }
        if ($id)
        {
            return $query->where("model",$model)->where("model_id",$id)->orderBy("created_at","desc");
        }
        return $query->where("model",$model)->orderBy("created_at","desc");
    }

    //Только по секции (Через маркер)
    public function scopeSection($query, $page)
    {
        $path = $page->model;
        return $query->where("model",$path)->where("model_id",null)->orderBy("created_at","desc");
    }

    //По секции включая субобъекты   (Через маркер)
    public function scopePage($query, $page)
    {
        $path = $page->model;
        return $query->where("model",$path)->orderBy("created_at","desc");
    }

    //Только по объекту (Через маркер)
    public function scopeInstance($query, $page)
    {
        $path = $page->model;
        $id = $page->id;
        return $query->where("model",$path)->where("model_id",$id)->orderBy("created_at","desc");
    }


    //============== GETTERS ============//

    //Автор
    function user()
    {
        return $this->belongsTo(User::class);
    }

    //Название модели/секции
    function getModelNameAttribute()
    {

        if ($this->model_id && config("admin-messages.sections." . $this->model.".instance_name"))
        {
            return config("admin-messages.sections." . $this->model.".instance_name")." #".$this->model_id ;
        }
        if (!$this->model_id && config("admin-messages.sections." . $this->model.".section_name"))
        {
            return config("admin-messages.sections." . $this->model.".section_name");
        }
        return config("admin-messages.sections._default.section_name");
    }

    function getInstanceNameAttribute()
    {
        if (!$this->model_id)
        {
            return null;
        }

        $model = config("admin-messages.sections." . $this->model.".instance_class");

        if (!$model)
        {
            return null;
        }

        $instance = $model::find($this->model_id);

        if (!$instance)
        {
            return null;
        }

        $field = config("admin-messages.sections." . $this->model.".name_field");

        if ($field)
        {
            return $instance->$field;
        }
        else
        {
            return $instance->name ?? $instance->title;
        }

    }

    //Название секции
    function getSectionNameAttribute()
    {
            return config("admin-messages.sections." . $this->model.".section_name") ?? $this->model;
    }

    //Иконка секции
    function getModelIconAttribute()
    {
        return config("admin-messages.sections." . $this->model.".icon") ?? config("admin-messages.sections._default.icon");
    }

    //Имя пользователя
    function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : "Не указан (API)";
    }

    //Ссылка на секцию/объект
    function getModelLinkAttribute()
    {
        if ($this->model == "_backend")
        {
            return "/admin";
        }

        if ($this->model ?? $this->model != "_default")
        {
            if ($this->model_id)
            {
                return "/admin/".$this->model."/".$this->model_id."/edit";
            }
            else
            {
                return "/admin/".$this->model;
            }
        }
        return null;
    }

    //Геттер для многострочного текстка
    function getMessageHtmlAttribute()
    {
        $link_regex = "/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/";

        $text = nl2br($this->message);
        $text = preg_replace($link_regex, '<a href="$0" target="_blank">$0</a>', $text);
        return $text;
    }

    //============== HIDDEN ATTRIBUTES ================//

    //Геттер для ссылки
    function getHrefAttribute()
    {
        return $this->values['href'];
    }

    //Сеттер для ссылки
    function setHrefAttribute($value)
    {
        $values = $this->values;
        $values['href']= $value;
        $this->values = $values;
    }

    //Значение по умолчанию для типа
    function getTypeAttribute()
    {
        return isset($this->attributes['type']) ? $this->attributes['type'] : "message";
    }

    function getTypeNameAttribute()
    {
        return config("admin-messages.types." . $this->type.".name");
    }
}
