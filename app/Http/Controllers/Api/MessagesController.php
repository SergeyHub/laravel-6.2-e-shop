<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

    //страница сообщений
    public function index(Request $request)
    {
        $messages = Message::orderBy("created_at","desc");
        $sorted = [
            "model"=>null,
            "user"=>null,
            "type"=>null
        ];
        if ($request->type)
        {
            $sorted['type'] = config("admin-messages.types.".$request->type.".name");
            $messages=$messages->type($request->type);
        }
        if ($request->model)
        {
            $sorted['model'] = config("admin-messages.sections.".$request->model.".section_name");
            $messages=$messages->model($request->model);
        }
        if ($request->user)
        {
            $sorted['user'] = User::find($request->user)->name;
            $messages=$messages->user($request->user);
        }
        $messages = $messages->get();
        $html = view("admin.messages.index")
            ->with([
                "messages"=>$messages,
                "sorted"=>(object)$sorted,
            ])
            ->render();
        return \AdminSection::view($html, 'Сообщения панели управления');
    }

    //Контент модального окна для одного сообщения
    public function showModal(Message $message)
    {
        return view("admin.messages.modal.show")->with('messages',new Collection([$message]));
    }

    //Контент модельного окна для сообщений секции/объекта
    public function showForModal($model, $id)
    {
        $messages =  Message::model($model, $id)->get();
        return view("admin.messages.modal.show")->with('messages',$messages);
    }

    //форма создания сообщения
    public function storeForm(Request $request)
    {
        $model = $request->model;
        $id = $request->id;
        return view("admin.messages.form")->with([
            "model"=>$model,
            "model_id"=>$id
        ]);
    }

    //создать сообщение
    public function store(Request $request)
    {
        $message = new Message($request->all());
        $message->user_id = access()->id;
        $message->save();
        return ['success'=>1,"message"=>"Сообщение сохранено!"];
    }

    //форма изменения сообщения
    public function updateForm(Message $message, Request $request)
    {
        return view("admin.messages.form")->with("message",$message);
    }

    //изменить сообщение
    public function update(Message $message, Request $request)
    {
        $message->fill($request->all());
        $message->save();
        return ['success'=>1,"message"=>"Сообщение изменено!"];
    }

    //подтвердить (закрыть) задачу
    public function confirm(Message $message)
    {
        $message->type = "resolved";
        $message->save();
        return ['success'=>1,"message"=>"Проблема отмечена как решённая!"];
    }

    //удалить сообщение
    public function remove(Message $message)
    {
        $message->delete();
        return ['success'=>1,"message"=>"Сообщение удалено!"];
    }

    //содержимое виджета (для обновления через аякс)
    public function widgetContent(Request $request)
    {
        return view("admin.widgets.messages.content")->with("url",$request->url);
    }
}
