<?php

namespace App\Http\Controllers;

use App\Models\{
    Blog,
    News,
    Promo,
    Page,
    Meta
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{

    public function newsIndex()
    {
        $class = "blog-page";
        $articles = News::where('status', 1)
            ->whereDate('created_at', '<=', \Carbon\Carbon::Now())
            ->orderBy('order', 'desc')->paginate(9);
        /* META */
        meta("news.index");
        breadcrumbs()
            ->root()
            ->to("Новости");

        $title = 'Новости';
        $view = 'articles news';
        $date = true;
        return view('pages.article.index', compact('articles', 'view', 'date', 'title', 'class'));
    }

    public function promoIndex()
    {
        $this->updatePromoDates();
        $class = "blog-page";
        $articles = Promo::where('status', 1)
            ->whereDate('created_at', '<=', \Carbon\Carbon::Now())
            ->orderBy('order', 'desc')->paginate(9);

        /* META */
        meta("promo.index");

        breadcrumbs()
            ->root()
            ->to("Акции");

        $title = 'Акции';
        $view = 'articles promos';
        $date = true;
        return view('pages.article.index', compact('articles', 'view', 'date', 'title', 'class'));
    }

    public function blogIndex()
    {
        $class = "blog-page";
        $articles = Blog::where('status', 1)
            ->whereDate('created_at', '<=', \Carbon\Carbon::Now())
            ->orderBy('order', 'desc')->paginate(9);
        /* META */
        meta("blog.index");
        breadcrumbs()
            ->root()
            ->to("Полезная информация");

        $title = 'Статьи';
        $view = 'articles';
        return view('pages.article.index', compact('articles', 'view', 'title', 'class'));
    }

    public function newsShow($slug)
    {
        $article = News::where('status', 1)->where('slug', $slug)->first();
        if (!$article) {
            abort(404);
        }
        meta()
            ->using($article)
            ->using("news.page")
            ->with($article);

        breadcrumbs()
            ->root()
            ->to("Новости", route("news.index"))
            ->to($article->title);

        $view = 'articles';
        return $this->show($article, $view);
    }

    public function promoShow($slug)
    {
        $this->updatePromoDates();
        $article = Promo::where('status', 1)->where('slug', $slug)->first();
        if (!$article) {
            abort(404);
        }
        meta()
            ->using($article)
            ->using("promo.page")
            ->with($article);

        breadcrumbs()
            ->root()
            ->to("Акции", route("promo.index"))
            ->to($article->title);

        $view = 'articles promo-page';
        return $this->show($article, $view);
    }

    public function blogShow($slug)
    {
        $article = Blog::where('status', 1)->where('slug', $slug)->first();
        if (!$article) {
            abort(404);
        }
        meta()
            ->using($article)
            ->using("blog.page")
            ->with($article);

        breadcrumbs()
            ->root()
            ->to("Блог", route("blog.index"))
            ->to($article->title);

        return $this->show($article);
    }

    private function show($article, $view = '')
    {

        $class = "blog-page";
        $view = $view ?? 'articles';
        $title = $article->title;

        return view('pages.article.show', compact('article', 'view', 'title', 'class'));
    }

    public function storeComment(Request $request)
    {
        captcha()->validate($request, true);
        //dd(request()->all());
        if ($request->ajax() && $request->name && $request->message) {
            $comment = new \App\Models\Comment();
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->message = $request->message;
            $comment->city = $request->city;
            $comment->blog_id = $request->blog_id;
            if (!$request->agreement) {
                $comment->save();
                Mail::to(getConfigValue('question_mail'))->send(new \App\Mail\Comment($comment->name, "Комментарий", $comment->message, $comment->getEditLink()));
            }
            $res = [
                'status' => 'success',
                'popup' => '#confirm-review',
                'fields' => [
                    '.js-review-modal-title' => 'Спасибо, ' . $comment->name . '!',
                    '.js-review-modal-text' => 'Ваш комментарий успешно добавлен. После прохождения модерации, он будет показан на сайте.',
                ]
            ];

            return response()->json($res);
        } else {
            return response()->json($request->all());
            //abort(404);
        }
    }

    private function updatePromoDates()
    {
        $now = \Carbon\Carbon::now();
        $promos = Promo::where('date_auto', 1)
            ->whereDate('date', '<=', $now)
            ->update(['date' => $now->addDays(15)]);
    }
}
