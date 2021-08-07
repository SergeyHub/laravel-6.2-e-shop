<?php


namespace App\Services;


use App\Models\Message;
use Illuminate\Support\Facades\Route;

class AdminMessagesService
{
    private static $_instance;

    /**
     * Return global instance of AdminMessagesService
     *
     * @return AdminMessagesService
     */
    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new AdminMessagesService();
    }

    //----------------------------------------------------------------------//

    //Маркеры страницы для сообщений
    public function getPageInfo($url = null)
    {
        $regex_admin = "/admin/";
        $regex_section= "/admin\/(\w+)/";
        $regex_instance= "/admin\/(\w+)\/(\d+)/";
        $uri = $url ?? request()->getUri();
        $contents = [];
        $res = [];
        if (preg_match($regex_instance, $uri,$contents))
        {
            $res = [
                "model" => $contents[1],
                "id" => $contents[2],
                "type" => "instance"
            ];
        }
        elseif (preg_match($regex_section, $uri,$contents))
        {
            $res = [
                "model" => $contents[1],
                "id" => null,
                "type" => "section",
            ];
        }
        elseif (preg_match($regex_admin, $uri,$contents))
        {
            $res = [
                "model" => '_backend',
                "id" => null,
                "type" => "backend"
            ];
        }
        else
        {
            $res = [
                "model" => '_default',
                "id" => null,
                "type" => "site"
            ];
        }

        return (object)$res;

    }

    //Получить сообщения для секции (исключая субъобъекты)
    public function getSectionMessages($url = null)
    {
        return Message::section($this->getPageInfo($url));
    }

    //Получить сообщения объекта
    public function getInstanceMessages($url = null)
    {
        return Message::instance($this->getPageInfo($url));
    }

    //Получить сообщения для секции (включая субъобъекты)
    public function getPageMessages($url = null)
    {
        return Message::page($this->getPageInfo($url));
    }

    //Общее количество Важных сообщений
    public function getProblemsCount()
    {
        return Message::problems()->count();
    }

    //Получить последние 5 любых сообщений
    public function getLastMessages()
    {
        $messages = Message::last(5)->get();
        return $messages;
    }

    //Есть ли сообщения для модели/секции
    public function hasForModel($model)
    {
        return Message::model($model)->count() > 0;
    }

    //Есть ли важные сообщения для модели/секции
    public function hasProblemsForModel($model)
    {
        return Message::model($model)->problems()->count() > 0;
    }

    //Есть ли заметки для модели/секции
    public function hasNotesForModel($model)
    {
        return Message::model($model)->notes()->count() > 0;
    }

    //Есть ли остальные сообщения для модели/секции
    public function hasAnyForModel($model)
    {
        return Message::model($model)->any()->count() > 0;
    }

    //роуты
    public static function routes()
    {
        Route::get("admin/messages", "App\Http\Controllers\Api\MessagesController@index")
            ->name("admin.messages")
            ->middleware("web", "admin");

        Route::get("admin/messages/store", "App\Http\Controllers\Api\MessagesController@storeForm")
            ->name("admin.messages.store.form")
            ->middleware("web", "admin");

        Route::post("admin/messages/store", "App\Http\Controllers\Api\MessagesController@store")
            ->name("admin.messages.store")
            ->middleware("web", "admin");

        Route::get("admin/messages/{message}/edit", "App\Http\Controllers\Api\MessagesController@updateForm")
            ->name("admin.messages.update.form")
            ->middleware("web", "admin");

        Route::post("admin/messages/{message}/edit", "App\Http\Controllers\Api\MessagesController@update")
            ->name("admin.messages.update")
            ->middleware("web", "admin");

        Route::get("admin/messages/{message}/modal", "App\Http\Controllers\Api\MessagesController@showModal")
            ->name("admin.messages.show.modal")
            ->middleware("web", "admin");

        Route::get("admin/messages/{model}/{id}/modal", "App\Http\Controllers\Api\MessagesController@showForModal")
            ->name("admin.messages.show.for.modal")
            ->middleware("web", "admin");

        Route::post("admin/messages/{message}/confirm", "App\Http\Controllers\Api\MessagesController@confirm")
            ->name("admin.messages.confirm")
            ->middleware("web", "admin");

        Route::post("admin/messages/{message}/remove", "App\Http\Controllers\Api\MessagesController@remove")
            ->name("admin.messages.remove")
            ->middleware("web", "admin");

        Route::get("admin/messages/widget", "App\Http\Controllers\Api\MessagesController@widgetContent")
            ->name("admin.messages.widget")
            ->middleware("web", "admin");
    }
}
