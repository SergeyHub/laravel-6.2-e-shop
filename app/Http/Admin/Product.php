<?php

namespace App\Http\Admin;

use AdminDisplayFilter;
use App\Jobs\SendProducts;
use App\Services\AdminService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use App\Http\Admin\Display\Extensions\DisplayFilterButtons;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use \App\Models\ProductPrice;
/**
 * Class Product
 *
 * @property \App\Models\Product $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Product extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Товары';
        $this->icon = 'fa fa-product-hunt';
        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            AdminService::setAlts($model);
            AdminService::setSlug($model);
            //$this->OptimizerChain($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            AdminService::setAlts($model);
            AdminService::setSlug($model);
            SendProducts::dispatch(new Collection([$model]));
            //$this->optimizerChain($model);
        });

    }

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->content;
    }

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatables()

            ->setApply(function ($query)  {
                //dd($request->all());
                //$query->orderBy('order', 'asc');
            })
            ->setOrder([[8, 'asc']])
            ->setColumns([
                AdminColumn::main('name', 'Название')->setSearchable(true),
                \AdminColumnEditable::checkbox('status','Доступен', 'Не доступен')
                    ->setLabel('Статус'),
                //----------------------------------- markers --------------------------------------------
                AdminColumn::custom('Описания', function (\Illuminate\Database\Eloquent\Model $model) {
                    return view('admin.product.mark')->with('model', $model);
                })->setWidth('200px')->setSearchable(false),
                AdminColumn::custom('СЕО', function (\Illuminate\Database\Eloquent\Model $model) {
                    return view('admin.product.mark_seo')->with('model', $model);
                })->setWidth('150px')->setSearchable(false),
                //----------------------------------------------------------------------------------------
                AdminColumn::lists('pricesOne.price','Цены')
                    ->setSearchable(false)
                    ->setOrderable(function($query, $direction) {

                        $query->join('product_prices', 'products.id', '=', 'product_prices.product_id');
                        $query->where('product_prices.country_id','1');
                        $query->where('product_prices.qty','1');
                        $query->select('products.*','product_prices.price');
                        $query->orderBy('product_prices.price', $direction);
                    }),
                AdminColumn::lists('filters.name','Фильтры')->setSearchable(false),
                /* AdminColumn::lists('brands.name','Бренд')->setSearchable(false), */

                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model,'/admin/products/');
                })->setWidth('150px')->setOrderable(function($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),
                //AdminColumn::order()->setLabel('Положение'),
               // \AdminColumnEditable::text('slug')->setLabel('Алиас'),

            ])
            ->setDisplaySearch(true)
            ->paginate(20);

        $display->getActions()->setView('product_actions')->setPlacement('panel.heading.actions');
        //----------------------- Filters --------------------------
        $display->extend('display_filter_buttons', new DisplayFilterButtons());
        $display->setDisplayFilterButtons([
            'description'=>'Без описания',
            'properties'=>'Без характеристик',
            'remote_id' => 'Без CRM ID',
            'images' => 'Мало картинок',
            'categories' => 'Мало категорий',
            'recommends' => 'Мало "рекомендуем также"',
            'params' => 'Указаны не все параметры',
        ]);
        $display->setFilters([
            //
            AdminDisplayFilter::custom('images')->setCallback(function($query, $value) {
                $query->whereRaw("images IS NULL")
                    ->orWhereRaw('(JSON_LENGTH(images) - JSON_LENGTH(images_visibility)) < 3')
                    ->orWhereRaw("((JSON_LENGTH(images) < 3) AND (JSON_LENGTH(images_visibility) = 0))")
                    ->orWhereRaw("((JSON_LENGTH(images) < 3) AND (images_visibility IS NULL))");
            })->setTitle('Мало картинок'),
            //
            AdminDisplayFilter::custom('description')->setCallback(function($query, $value) {
                $query->whereRaw("length(description) < 5")
                    ->orWhere("description",null);
                   // ->orWhereRaw("length(short_description) < 5")
                    //->orWhere("short_description",null);
            })->setTitle('Без описаний'),
            //
            AdminDisplayFilter::custom('properties')->setCallback(function($query, $value) {
                $query->whereRaw("length(feature) < 5")->
                orWhere("feature",null);;
            })->setTitle('Без характеристик'),
            //
            AdminDisplayFilter::custom('remote_id')->setCallback(function($query, $value) {
                $query->whereRaw("remote_id IS NULL")
                    ->orWhereRaw('remote_id < 1');
            })->setTitle('Без CRM ID'),
            //
            AdminDisplayFilter::custom('categories')->setCallback(function ($query, $value) {
                $query->whereRaw("((SELECT  COUNT(*) FROM product_category WHERE product_id = products.id) < 3)");
            })->setTitle('Мало категорий'),
            //
            AdminDisplayFilter::custom('recommends')->setCallback(function ($query, $value) {
                $query->whereRaw("((SELECT  COUNT(*) FROM product_recomends WHERE product_id = products.id) < 3)");
            })->setTitle('Мало "рекомендуем также"'),
            //
            AdminDisplayFilter::custom('params')->setCallback(function($query, $value) {
                $query
                    ->orWhereRaw('length(channels) < 1')->orWhereRaw('channels IS NULL')
                    ->orWhereRaw('length(bandwidth) < 1')->orWhereRaw('bandwidth IS NULL')
                    ->orWhereRaw('length(frequency) < 1')->orWhereRaw('frequency IS NULL')
                    ->orWhereRaw('length(depth) < 1')->orWhereRaw('depth IS NULL');
            })->setTitle('Указаны не все параметры'),
        ]);
        //---------------------- END Filters -------------------------
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $product = $id ? \App\Models\Product::find($id) : false;

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) use($product)  {
            $tabs = [];
            $elements = [
                //AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name', 'Товар %tovar_name%')->required()->addValidationRule(Rule::unique('products', 'name')->ignore($product), 'Имя уже зарегистрировано')])
                ->addColumn([AdminFormElement::text('name1', 'Товара (Кого?, Чего?) %tovar_name1%')])
                ->addColumn([AdminFormElement::text('name2', 'Товару (Кому?, Чему?) %tovar_name2%')]),
                AdminFormElement::columns()
                ->addColumn([AdminFormElement::text('name3', 'Товара (Кого?, Что?) %tovar_name3%')])
                ->addColumn([AdminFormElement::text('name4', 'Товаром (Кем?, Чем?) %tovar_name4%')])
                ->addColumn([AdminFormElement::text('name5', 'Товаре (О ком?, О чем?) %tovar_name5%')]),

            ];
            //$elements[] = AdminFormElement::text('short_name', 'Короткое название %tovar_short_name%');
            $elements[] = AdminFormElement::prices("Цена за единицу товара")
                ->addField(1,"Базовая цена")
                ->addField(0,"Старая цена (для рассчёта скидки)")
                ->setHelpText('Если не указана цена для страны (не Россия), то она будет рассчитываться цена в России * курс');

            //---------------------------------------------- CRM SYNC ------------------------------------------------//
            $elements[] = AdminFormElement::html("<h4 class='text-center'><i class='fa fa-database'></i> Синхронизация с CRM</h4>");
            $elements[] = AdminFormElement::columns()
                ->addColumn([AdminFormElement::text('remote_id', 'ID товара в CRM')
                    ->addValidationRule('nullable')
                    ->addValidationRule(Rule::unique('products', 'remote_id')->ignore($product), 'Идентификатор уже зарегистрирован')
                ])
                ->addColumn([AdminFormElement::number('price_diff', 'Отклонение цены от CRM')
                    ->setHelpText('Это число будет прибавлено к цене в рублях при обновлении цен с CRM')]);
            //-------------------------------------------------------------------------------------------------------

            $elements[] = AdminFormElement::columns()
                ->addColumn([AdminFormElement::checkbox('status', 'Доступен')])
                ->addColumn([AdminFormElement::checkbox('under_order', 'Под заказ')])
                ->addColumn([AdminFormElement::checkbox('front', 'Отображать на главной')])
                ->addColumn([AdminFormElement::checkbox('bestseller', 'Хит')])
                ->addColumn([AdminFormElement::checkbox('new', 'Новинка')]);

            /*$elements[] = AdminFormElement::multiselect('categories', 'Категории',$this->categoryTree())
                                ->setSortable(false)
                                ->setValueSkipped(true)
                                ->setView('multiselectRequired')
                                ->required();


            $elements[] = AdminFormElement::multiselect('similar', 'Похожие товары')
                                ->setModelForOptions(\App\Models\Product::class)
                                ->setDisplay('name');
            $elements[] = AdminFormElement::multiselect('recommends', 'Рекомендуем также')
                                ->setModelForOptions(\App\Models\Product::class)
                                ->setDisplay('name');*/
            /* $elements[] = AdminFormElement::multiselect('buywith', 'С этим товаром покупают')
                                ->setModelForOptions(\App\Models\Product::class)
                                ->setDisplay('name'); */
            $elements[] = AdminFormElement::imagesWithFlags('images', 'Изображения')->setUploadFileName(function (\Illuminate\Http\UploadedFile $file) use ($product) {
                //----------------- SET FILENAME BY ALIAS -------------------
                if ($product) {
                    $i = 0;
                    $filename = $product->slug . "." . $file->getClientOriginalExtension();
                    while (is_file(base_path()."/public/images/uploads/".$filename))
                    {
                        $i++;
                        $filename = $product->slug . '_'.$i."." . $file->getClientOriginalExtension();
                    }
                    return $filename;
                }
                //-----------------------------------------------------------
                return $file->getClientOriginalName();
            });
            $elements[] = AdminFormElement::textarea('image_alts', 'Атрибут alt для картинок')->setHelpText('Каждый alt с новой строки. 1я строка = 1я картинка');

            $tabs[] = AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Основное');

            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::filters("filters", "Фильтры товара (кластеры, признаки)")
            ]))->setLabel('Фильтры');

            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::multiselectTabled()
                    ->setLabel("Связи с другими товарами")
                    ->addTargetField("similar", "Похожие")
                    ->addTargetField("recommends", "Рекомендуемые")
                    ->setModelForOptions(\App\Models\Product::class)
                    ->setDisplay('name')
                    ->setName('Товары')
            ]))->setLabel('Связанные товары');

            $tabs[] = AdminDisplay::tab(AdminForm::elements([
                /* AdminFormElement::ckeditor('short_description', 'Описание в тизере'), */
                AdminFormElement::ckeditor('description', 'Описание'),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('channels', 'Количество каналов')])
                    ->addColumn([AdminFormElement::text('bandwidth', 'Полоса пропускания')])
                    ->addColumn([AdminFormElement::text('frequency', 'Частота дискретизации')])
                    ->addColumn([AdminFormElement::text('depth', 'Глубина памяти')]),
                AdminFormElement::textarea('feature', 'Характеристики')->setRows(5)->setHelpText('Каждый парамет с новой строки.<br>Название и значение разделять | '),
                /* AdminFormElement::ckeditor('review', 'Обзор'), */

            ]))->setLabel('Описания');
            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('slug', 'Алиас'),
                AdminFormElement::text('meta_title', 'Заголовок META')->setHelpText('Доступны переменные: %product% -> Название продукта, %country% -> Страна производителя, %category% -> Имя категории. %phone%, %phone2%, %address%, %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2)->setHelpText('Доступны переменные: %product% -> Название продукта, %country% -> Страна производителя, %category% -> Имя категории. %phone%, %phone2%, %address%, %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::text('meta_tags', 'Ключи META')->setHelpText('Доступны переменные: %product% -> Название продукта, %country% -> Страна производителя, %category% -> Имя категории. %phone%, %phone2%, %address%, %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
            ]))->setLabel('SEO');
            return $tabs;
        });
        return AdminForm::form()
            //instance actions
            ->addElement(AdminFormElement::html(view('admin.instance_actions',['href'=>$product ? $product->getUrl() : ""])->with("model",$product)))
            ->addElement($tabs);
    }
    public static function categoryTree(&$tree = [], $prefix='' ,$parent = 0)
    {
        if ($parent) {
            $categories = \App\Models\Category::where('parent_id',$parent)->orderBy('order')->get();
        } else {
            $categories = \App\Models\Category::whereNull('parent_id')->orWhere('parent_id',$parent)->orderBy('order')->get();
        }
        foreach ($categories as $key => $category) {
            $tree[$category->id] = $prefix.$category->name;
            if (\App\Models\Category::where('parent_id',$category->id)->count()) {
                self::categoryTree($tree,'- ',$category->id);
            }
        }

        return $tree;
    }
    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
