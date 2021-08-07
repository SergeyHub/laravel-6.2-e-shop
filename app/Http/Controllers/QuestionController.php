<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        captcha()->validate($request, true);
        if ($request->name && $request->email && $request->message) {
            if (!$request->agreement) {
                $question = new \App\Models\Question();
                $question->name = $request->name;
                $question->email = $request->email;
                $question->title = $request->title;
                $question->question = $request->message;
                $question->product_id = $request->product_id;

                $question->save();
                Mail::to(getConfigValue('question_mail'))->send(new \App\Mail\Comment($question->name, "Вопрос",$question->question,$question->getEditLink()));
                //Mail::to(getConfigValue('question_mail'))->send(new \App\Mail\Question($question));
            }
            $res = [
                'status' => 'success',
                'popup'=> '#confirm-review',
                'fields'=> [
                    '.js-review-modal-title' => 'Спасибо, '.$question->name.'!',
                    '.js-review-modal-text' => 'Ваш вопрос отправлен.<br> Вы получите уведомление об ответе на e-mail: <strong>'.$request->email.'</strong><br>
                        <button type="button" class="btn btn-light mx-auto mt-5" data-dismiss="modal" aria-label="Закрыть">Вернуться на сайт</button>',
                ]
            ];

            return response()->json($res);
        } else {
            //return response()->json($request->all());
            abort(404);
        }
    }
    public function showMail($hash)
    {
        $question = \App\Models\Question::where('mail_hash',$hash)->first();
        if (!$question) { abort(404); }

        return (new \App\Mail\Answer($question))->render();
    }
}
