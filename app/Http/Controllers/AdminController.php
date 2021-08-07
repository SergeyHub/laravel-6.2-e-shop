<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateCities;
use App\Jobs\UpdateNames;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Set;
use App\Services\CatalogService;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use AdminSection;
use \App\Models\Page;
use Illuminate\Support\Facades\Session;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Jobs\UpdatePrices;

class AdminController extends Controller
{
    public function index()
    {

        $content = view('admin.dashboard', [
            'counts' => [
                'products' => \App\Models\Product::count(),
                'cities' => \App\Models\City::count(),
                'orders' => \App\Models\Order::count(),
                'reviews' => \App\Models\Review::count(),
            ],

            'orders' => \App\Models\Order::orderBy('created_at', 'desc')->limit(10)->get(),
            'callbacks' => \App\Models\Callback::orderBy('created_at', 'desc')->take(5)->get(),

            'reviews' => \App\Models\Review::orderBy('created_at', 'desc')->where("status",0)->get(),
            'questions' => \App\Models\Question::orderBy('created_at', 'desc')->where("status",0)->get(),
            'comments' => \App\Models\Comment::orderBy('created_at', 'desc')->where("status",0)->get(),
        ]);
        return AdminSection::view($content, '');
    }
    public function frontpage()
    {
        $formPrimary = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name', 'Город %city%')->required()])
                    ->addColumn([AdminFormElement::text('name1', 'Города (Кого?, Чего?) %city1%')])
                    ->addColumn([AdminFormElement::text('name2', 'Городу (Кому?, Чему?) %city2%')]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name3', 'Город (Кого?, Что?) %city3%')])
                    ->addColumn([AdminFormElement::text('name4', 'Городом (Кем?, Чем?) %city4%')])
                    ->addColumn([AdminFormElement::text('name5', 'Городе (О ком?, О чем?) %city5%')]),
                //->addColumn([AdminFormElement::text('slug', 'Ссылка')])
                AdminFormElement::text('slug', 'Субдомен'),
            ])
        );
        $formFront = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('front_title', 'Заголовок блока'),
                AdminFormElement::image('front_image', 'Изображение'),
                AdminFormElement::ckeditor('front_description', 'Текст'),
                AdminFormElement::text('meta_title', 'Заголовок META'),
                AdminFormElement::textarea('meta_description', 'Описание META'),
                AdminFormElement::text('meta_tags', 'Теги META'),

            ])
        );
        $formContacts = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::ckeditor('schedule', 'Время работы'),
                AdminFormElement::ckeditor('address', 'Адрес'),
                AdminFormElement::textarea('map', 'Карта'),
            ])
        );
        $formRobots = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::textarea('robots', 'Файл robots.txt')->setRows(30)->setHelpText('Если оставить пустым, то будет использоваться файл robots по умолчанию'),
            ])
        );
        $tabs = AdminDisplay::tabbed();
        $tabs->appendTab($formPrimary, 'Общая информация');
        $tabs->appendTab($formFront, 'Главная страница');
        $tabs->appendTab($formContacts, 'Контакты');
        $tabs->appendTab($formRobots, 'Файл robots.txt');
        return $tabs;
        $msg = false;
        $page = Page::find(1);
        //$content = view('admin.front_page',['msg' => $msg,'page'=>$page]);

        return AdminSection::view($content, 'Главная страница');
    }

    public function contactsExport()
    {
        $cities = \App\Models\City::orderBy('name')
                                ->get([
                                    'name',
                                    //'email',
                                    'phone1',
                                    'phone2',
                                    'address',
                                    'schedule',
                                    'lat_map',
                                    'lng_map',
                                    'region',
                                    'show_default'
                                ])
                                ->toArray();
        $headers = [
            'Название (НЕ МЕНЯТЬ)',
            'Телефон #1',
            'Телефон #2',
            'Адрес',
            'Время работы',
            'Широта',
            'Долгота',
            'Регион',
            'Видимость(0\1)'
        ];

        $filename ='cities_'.date('d.m.Y-H.i').'.csv';
        header('Content-Type: text/csv; charset=utf-8');
        Header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');

        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);
        foreach ($cities as $row){
            fputcsv($output, $row);
        }
        fclose($output);
    }
    public function contactsImportForm() {
        $content = view('admin.import')->render();
	    return AdminSection::view($content, 'Импорт городов');
    }
    public function contactsImport(Request $request) {
        if ($request->file('cities') && $request->file('cities')->isValid()) {
            $request->file('cities')->storeAs('import','cities.csv');
            $file = fopen(storage_path('app/import/cities.csv'), 'r');
            $cities = \App\Models\City::all();
            while (($line = fgetcsv($file)) !== FALSE) {
                if ($city = $cities->where('name',$line[0])->first()) {
                    $city->phone1 = $line[1];
                    $city->phone2 = $line[2];
                    $city->address = $line[3];
                    $city->schedule = $line[4];
                    $city->lat_map = $line[5];
                    $city->lng_map = $line[6];
                    $city->region = $line[7];
                    $city->show_default = $line[8];
                    $city->save();
                }
            }
            fclose($file);

            \MessagesStack::addSuccess('Контакты обновлены');
        } else {
            \MessagesStack::addError('Ошибка загрузки файла');
        }
        $content = view('admin.import')->render();
	    return AdminSection::view($content, 'Импорт городов');
    }

    //====================== META IMPORT/EXPORT =============================
    public function metaExport()
    {
        $items = [];
        $pages = Page::orderBy('slug')->get();
        foreach ($pages as $key => $page) {
            $items[] = [
                '/'.$page->slug,
                $page->meta_title,
                $page->meta_description,
                $page->meta_tags,
                $page->title,
                'Page',
                $page->id,
            ];
        }
        $categories = Category::orderBy('order')->get();
        foreach ($categories as $key => $category) {
            $items[] = [
                '/catalog/'.$category->slug,
                $category->meta_title,
                $category->meta_description,
                $category->meta_tags,
                $category->name,
                'Category',
                $category->id,
            ];
        }
         $sets = Set::orderBy('order')->get();
         foreach ($sets as $key => $set) {
             $items[] = [
                 '/catalog/'.$set->slug,
                 $set->meta_title,
                 $set->meta_description,
                 $set->meta_tags,
                 $set->name,
                 'Set',
                 $set->id,
             ];
         }
        $products = Product::orderBy('order')->get();
        foreach ($products as $key => $product) {
            $items[] = [
                '/'.$product->getPath(),
                $product->meta_title,
                $product->meta_description,
                $product->meta_tags,
                $product->name,
                'Product',
                $product->id,
            ];
        }
        /* $news = News::orderBy('order')->get();
         foreach ($news as $key => $item) {
             $items[] = [
                 '/news/'.$item->slug,
                 $item->meta_title,
                 $item->meta_description,
                 $item->meta_tags,
                 $item->title,
                 'News',
                 $item->id,
             ];
         }*/
        $blogs = Blog::orderBy('order')->get();
        foreach ($blogs as $key => $item) {
            $items[] = [
                '/blog/'.$item->slug,
                $item->meta_title,
                $item->meta_description,
                $item->meta_tags,
                $item->title,
                'Blog',
                $item->id,
            ];
        }
        /*$promos = Promo::orderBy('order')->get();
        foreach ($promos as $key => $item) {
            $items[] = [
                '/promo/'.$item->slug,
                $item->meta_title,
                $item->meta_description,
                $item->meta_tags,
                $item->title,
                'Promo',
                $item->id,
            ];
        }*/
        $headers = [
            'Url',
            'Meta Title',
            'Meta Description',
            'Meta Keywords',
            'H1',
            'Type (НЕ МЕНЯТЬ)',
            'ID (НЕ МЕНЯТЬ)',
        ];

        $filename ='metaData_'.date('d.m.Y-H.i').'.csv';
        header('Content-Type: text/csv; charset=utf-8');
        Header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');

        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);
        foreach ($items as $row){
            fputcsv($output, $row);
        }
        fclose($output);
    }
    public function metaImportForm() {
        $content = view('admin.importMeta')->render();
        return AdminSection::view($content, 'Импорт метатегов');
    }
    public function metaImport(Request $request) {
        if ($request->file('metas') && $request->file('metas')->isValid()) {
            $request->file('metas')->storeAs('import','metas.csv');
            $file = fopen(storage_path('app/import/metas.csv'), 'r');
            $i = 0;
            while (($line = fgetcsv($file)) !== FALSE) {
                if (!$i) {
                    $i++;
                    continue;
                }
                $modelName = $line[5] ?? '';
                $id = $line[6] ?? '';
                if (!$modelName || !$id) continue;

                switch ($modelName) {
                    case 'News':
                    case 'Blog':
                    case 'Promo':
                    case 'Page':
                        $h1 = 'title';
                        break;
                    default:
                        $h1 = 'name';
                        break;
                }
                $modelName = "\App\Models\\".$modelName;
                if (class_exists($modelName))
                {
                    $model = $modelName::find($id);
                    $model->meta_title = $line[1] ?? '';
                    $model->meta_description = $line[2] ?? '';
                    $model->meta_tags = $line[3] ?? '';
                    if ($title = ($line[4] ?? null)) {
                        $model->$h1 = $title;
                    }
                    if ($slugLine = ($line[0] ?? null)) {
                        $slugArray = explode('/',$slugLine);
                        $slug = array_pop($slugArray);
                        $model->slug = $slug;
                    }
                    $model->save();
                }
            }
            fclose($file);

            \MessagesStack::addSuccess('Мета данные обновлены');
        } else {
            \MessagesStack::addError('Ошибка загрузки файла');
        }
        $content = view('admin.importMeta')->render();
        return AdminSection::view($content, 'Импорт метатегов');
    }
    //=======================================================================

    public function saveImage(Request $request)
    {
        $path = 'images/uploads';
        $file = request()->upload;

        $settings = [];
        $filename = $file->getClientOriginalName();
        //dd(request()->all());
        if (class_exists('Intervention\Image\Facades\Image') && (bool) getimagesize($file->getRealPath())) {

            $image = \Intervention\Image\Facades\Image::make($file);

            foreach ($settings as $method => $args) {
                call_user_func_array([$image, $method], $args);
            }

            $value = $path.'/'.$filename;

            $image->save(public_path().'/'.$value);
            $res = "<!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <title>Document</title>
            </head>
            <body>
            <script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(".request()->CKEditorFuncNum.", '/".$value."');</script>
            </body>
            </html>";
            return $res;
            return response()->json(['test'=>'test'])->withCallback($request->input('callback'));
        }

        $file->move(public_path().'/'.$path, $filename);

        //S3 Implement
        $value = $path.'/'.$filename;
        $res = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '/".$value."');</script>";
        return $res;
        return response()->json(['uploaded'=>1,'url' => '/'.$value, 'fileName' => $filename]);
    }
    public function saveFieldImage(Request $request)
    {
        $path = 'images/uploads';
        $file = $request->file;
        $settings = [];
        $filename = $file->getClientOriginalName();

        if (class_exists('Intervention\Image\Facades\Image') && (bool) getimagesize($file->getRealPath())) {

            $image = \Intervention\Image\Facades\Image::make($file);

            foreach ($settings as $method => $args) {
                call_user_func_array([$image, $method], $args);
            }

            $value = $path.'/'.$filename;

            $image->save($value);

            return response()->json(['path' => asset($value), 'value' => $value]);
        }

        $file->move($path, $filename);

        //S3 Implement
        $value = $path.'/'.$filename;

        return response()->json(['path' => asset($value), 'value' => $value]);
    }
    public function saveFile(Request $request)
    {
        $path = 'files/uploads';
        $file = $request->file;
        $settings = [];
        $filename = $file->getClientOriginalName();

        $file->move($path, $filename);

        //S3 Implement
        $value = $path.'/'.$filename;

        return response()->json(['path' => asset($value), 'value' => $value]);
    }
    public function changeOrder(Request $request)
    {
        $new = (int) $request->new;
        $old = (int) $request->old;
        $model = $request->model;
        //dd($model);
        if ($new > $model::count()-1) {
            $new = $model::count()-1;
        }
        if ($new != $old) {
            if ($new < $old) {
                $model::where('order','>=',$new)->where('order','<',$old)->increment('order');
            } else {
                $model::where('order','<=',$new)->where('order','>',$old)->decrement('order');
            }
        }
        $model::where('id',$request->id)->update(['order' => $new]);
        return back();
        dd($request->all());
    }
    public function updatePrices()
    {
        \MessagesStack::addSuccess('Цены обновлены');
        UpdatePrices::dispatch();
        return redirect('admin\products');
    }
    public function remoteUpdatePrice()
    {
        if (request()->token) {
            UpdatePrices::dispatch();
            return response()->json(['status'=>'success']);
        }
        abort(404);
    }

    /**
     * Run updateNames job, loading product name cases from crm
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function updateNames()
    {
        \MessagesStack::addSuccess('Имена загружены');
        UpdateNames::dispatch();
        return redirect('admin\products');
    }

    /**
     * Run UpdateCities job, loading cities contacts from crm
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function updateCities()
    {
        \MessagesStack::addSuccess('Контакты городов обновлены');
        UpdateCities::dispatch();
        return redirect('admin\cities');
    }

    /**
     * Create products from CRM IDs
     *
     * @param Request $request
     * @return array
     */
    public function createByRemote(Request $request)
    {
        $ids = $request->get('ids',"");
        $ids = trim(preg_replace('/\s+/', '', $ids));
        $ids = explode(",",$ids);
        $res = CatalogService::makeProductsFromRemote($ids);
        \MessagesStack::addSuccess('Добавлено '.$res[0].' товара');
        return ["count"=>$res[0],"error"=>$res[1]];
    }

    public function compress()
    {
        $list = [];
        $this->listFolderFiles($list, public_path('images/uploads'));
        foreach ($list as $key => $image) {
            app(\Spatie\ImageOptimizer\OptimizerChain::class)->optimize($image);
        }
        \MessagesStack::addSuccess('Картинки сжаты');
        return redirect('\admin\products');
    }
    private function listFolderFiles(&$list,$dir){
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        if (count($ffs) < 1)
            return;

        foreach($ffs as $ff){
            if(is_dir($dir.'/'.$ff))  {
                $this->listFolderFiles($list,$dir.'/'.$ff);
            } else {
                if (\strpos(mime_content_type($dir.'/'.$ff),'image') !== false) {
                    $list[] = $dir.'/'.$ff;
                }
            }
        }
    }
    public function downloadFile($id,$file)
    {

        $item = \App\Models\Callback::find($id);
        if ($item && ($item->files[$file] ?? null)) {
            return \Storage::download($item->files[$file]);
        }
        return back();
    }

    /**
     *
     * Compress single image or images array
     * @return array
     * @var Request $request ;
     */
    public function compressImage(Request $request)
    {
        $token = $request->get('token');
        \App\Models\Config::updateOrInsert(["country_id"=>1,"type"=>"text","name"=>"TinyPNG.API.Key","key"=>"TinyPNGApiKey"],["value"=>$token]);

        //try convert list of images
        $images = $request->get('images', null);
        if (is_array($images)) {

            $result = [];
            foreach ($images as $image) {
                $result[] = ImageOptimizer::Compress($image, $token);
            }
            //calc statistic
            $count = count($result);
            $success = 0;
            $message = "";
            $old = 0;
            $new = 0;
            $api_count = 0;
            foreach ($result as $res) {
                if ($res['status']) {
                    $success++;
                    $api_count = $res['api_count'];
                    $old += $res['old'];
                    $new += $res['new'];
                } else {
                    //collecting messages
                    $message .= $res['message'] . "<br>";
                }
            }
            return [
                'status' => true,
                'trace' => $result,
                'count' => $count,
                'success' => $success,
                'message' => $message,
                'old' => $old,
                'new' => $new,
                'api_count' => $api_count
            ];
        }
        //--------------------------

        //try convert single image
        $image = $request->get('image', null);
        if (is_string($image)) {
            return ImageOptimizer::Compress($image, $token);
        }
        //------------------------
        //trow error
        return abort(400);
    }
}
