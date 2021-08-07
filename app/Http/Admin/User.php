<?php


namespace App\Http\Admin;


use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

class User extends Section implements Initializable
{
    function initialize()
    {
        $this->title = "Аккаунты";
        $this->icon = "fa fa-lock";
        $this->deleting(function ($config, $model){
            if($model->id == 1 || $model->role == "admin")
            {
                return false;
            }
            return true;
        });
        // TODO: Implement initialize() method.
    }
    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->admin;
    }

    function onDisplay()
    {
        $display = \AdminDisplay::datatables();
        $display->setColumns([
           \AdminColumnEditable::text("name", "Имя"),
            \AdminColumnEditable::text("email","Email"),
            \AdminColumnEditable::text("new_password","Установить пароль"),
            \AdminColumnEditable::select("role","Права")->setOptions(["manager"=>"Call-Менеджер","content"=>"Контент-Менеджер","admin"=>"Администратор"]),
        ]);
        return $display;
    }

    function onEdit($id = null)
    {
        $form = \AdminForm::panel()->addBody([
            \AdminFormElement::text("name", "Имя"),
            \AdminFormElement::text("email","Email"),
            \AdminFormElement::text("new_password","Установить пароль"),
            \AdminFormElement::select("role","Права")->setOptions(["manager"=>"Call-Менеджер","content"=>"Контент-Менеджер","admin"=>"Администратор"]),
        ]);
        return $form;
    }

    function onCreate()
    {
        return $this->onEdit();
    }

    function onDelete($id)
    {

    }
}
