<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* META */
        $meta = [
            'title' => replaceVariables(getConfigValue('reviews_title')),
            'description' => replaceVariables(getConfigValue('reviews_description')),
            'keywords' => replaceVariables(getConfigValue('reviews_keywords')),
        ];
        /* END META */
        $breadcrumbs = [
            ['href' => route('front'), 'name' => 'Главная'],
            ['href' => route('review.index'), 'name' => 'Отзывы'],

        ];
        $reviews = Review::where('status',1)->orderBy('created_at','desc')->paginate(20);
        return view('pages.reviews',[
            'reviews'=>$reviews,
            'breadcrumbs' => $breadcrumbs,
            'meta' => $meta,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        captcha()->validate($request, true);
        //dd(request()->all());
        if ($request->name && $request->phone && $request->message) {
            $review = new \App\Models\Review();
            $review->name = $request->name;
            $review->title = $request->title;
            $review->email = $request->email;
            $review->phone = $request->phone;
            $review->message_full = $request->message;
            $review->product_id = $request->product_id;
            if (!$request->agreement) {
                $review->save();
                Mail::to(getConfigValue('question_mail'))->send(new \App\Mail\Comment($review->name, "Отзыв",$review->message_full,$review->getEditLink()));
            }
            $res = [
                'status' => 'success',
                'popup'=> '#confirm-review',
                'fields'=> [
                    '.js-review-modal-title' => 'Спасибо, '.$review->name.'!',
                    '.js-review-modal-text' => 'Ваш отзыв успешно добавлен. После прохождения модерации, он будет показан на сайте.',
                ]
            ];

            return response()->json($res);
        } else {
            //return response()->json($request->all());
            abort(404);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::find($id);
        if($review) {
            /* META */
            $meta = [
                'title' => replaceVariables($review->meta_title ? $review->meta_title : 'Отзыв'),
                'description' => replaceVariables($review->meta_description),
                'keywords' => replaceVariables($review->meta_tags),
            ];
        /* END META */
            $breadcrumbs = [
                ['href' => route('front'), 'name' => 'Главная'],
                ['href' => route('review.index'), 'name' => 'Отзывы'],
                ['href' => route('review.show',['id'=>$id]), 'name' => 'Отзыв пользователя'],
            ];
            return view('pages.review', [
                'review' => $review,
                'breadcrumbs' => $breadcrumbs,
                'meta' => $meta,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }

    /* =========================== REVIEW GENERATOR ============================== */

    public function getGeneratorForm()
    {
        $content = view("admin.editor.review-generator");
        return \AdminSection::view($content, 'Генератор отзывов');
    }

    public function postCheckGeneratorForm(Request $request)
    {
        $response = ["status"=>1, "message"=>"Строки "];
        $rows = $request->rows;
        array_pop($rows);
        $count = 0;
        foreach ($rows as $row)
        {
            $count++;
            $date = date_parse_from_format("d.m.Y", trim($row[0]));
            if ($date['error_count'] || Product::where('name',trim($row[1]))->count() == 0)
            {
                $response['status'] = 0;
                $response['message'].=$count." ";
            }
        }
        return $response;
    }

    public function postCommitGeneratorForm(Request $request)
    {
        $check = $this->postCheckGeneratorForm($request);
        if ($check['status'] == 0)
        {
            return $check;
        }
        $rows = $request->rows;
        array_pop($rows);
        $count = 0;
        foreach ($rows as $row)
        {
            $count++;
            $review = new Review();
            $review->name = trim($row[2]);
            $review->message_full = trim($row[3]);
            $review->status = 0;
            $review->product_id = Product::where('name',trim($row[1]))->first()->id;
            $review->created_at = \DateTime::createFromFormat("d.m.Y",trim($row[0]));
            $review->save();
        }
        \MessagesStack::addSuccess('Добавлено '.$count.' элементов');
        return ["status"=>1];
    }

    /* =========================== END REVIEW GENERATOR ========================== */
}
