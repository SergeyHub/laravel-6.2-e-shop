<?php

namespace App\Http\Controllers\Api;

use App\Jobs\UpdateCatalog;
use App\Models\Comment;
use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuickActionsController extends Controller
{
    function quickQuestionAnswer(Question $question, Request $request)
    {
        $question->status = 1;
        $question->answer = $request->answer;
        $question->sendAnswer();
        $question->save();
        return 1;
    }

    function quickReviewStatus(Review $review, Request $request)
    {
        $review->status = 1;
        $review->save();
        return 1;
    }

    function quickCommentStatus(Comment $comment, Request $request)
    {
        $comment->status = 1;
        $comment->save();
        return 1;
    }

    public function updateCatalog()
    {
        \MessagesStack::addSuccess('Каталог обновлён');
        UpdateCatalog::dispatch();
        return redirect('admin\products');
    }

	function toggleEditMode($state)
	{
		session(['editmode' => ($state > 0)]);
        if ($state > 0) {
			\MessagesStack::addSuccess('Режим редактора включен');
        } else {
            \MessagesStack::addSuccess('Режим редактора выключен');
        }
        return redirect('/admin');
	}
}
