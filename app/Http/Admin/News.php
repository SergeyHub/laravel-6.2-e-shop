<?php

namespace App\Http\Admin;

use App\Services\AdminService;
use App\Services\MainService;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
/**
 * Class News
 *
 * @property \App\Models\News $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Новости';
        $this->icon = 'fa fa-book';
        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {

            AdminService::setSlug($model);
            $this->saveValues($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {

            AdminService::setSlug($model);
            $this->saveValues($model);
        });
    }

    public function saveValues(&$model)
    {
        $model->fields = request()->fields;
        $model->save();
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
        return AdminDisplay::datatables()

            ->setApply(function ($query) {
                //$query->orderBy('created_at', 'desc');
            })
            ->setOrder([[6, 'asc']])
            ->setColumns([
                AdminColumn::datetime('created_at')->setFormat('d.m.Y')->setLabel('Дата'),
                \AdminColumnEditable::checkbox('status','Доступен','Не доступен')->setLabel('Статус'),
                AdminColumn::main('title')->setLabel('Заголовок'),
                AdminColumn::text('slug')->setLabel('Алиас'),
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model,'/admin/news/');
                })->setWidth('150px')->setOrderable(function($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),
            ])
            //->setDisplaySearch(true)
            ->paginate(50);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function () use($id) {
            $tabs = [];
            $items = [
                ['type' => 'image','key'=>'image','title' => 'Image'],
                ['type' => 'text','key'=>'title_en','title'=>'Name [EN]'],
                ['type' => 'text','key'=>'title_de','title'=>'Name [DE]'],
                ['type' => 'text','key'=>'title_ru','title'=>'Name [RU]'],
                ['type' => 'clearfix'],
                ['type' => 'ckeditor','key'=>'text_en','title'=>'Text [EN]'],
                ['type' => 'ckeditor','key'=>'text_de','title'=>'Text [DE]'],
                ['type' => 'ckeditor','key'=>'text_ru','title'=>'Text [RU]'],
            ];
            $items = [];
            if ($id && $news = \App\Models\News::find($id)) {
                $items = $news->fields ?? [];
            }

            $prefix = 'fields';
            $title = 'Поля';
            $products = \App\Models\Product::orderBy('name')->pluck('name','id')->toArray();

            $elements = [
                AdminFormElement::text('title', 'Заголовок')->required(),
                AdminFormElement::html('<div class="clearfix"></div>'),
                AdminFormElement::view('admin.multi_fields',compact('items','prefix','title','products')),
                AdminFormElement::html('<div class="clearfix"></div>'),
                //AdminFormElement::ckeditor('body', 'Содержимое'),
            ];

            $tabs[] = AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Содержимое');
            $tabs[] = AdminDisplay::tab(AdminForm::elements([
                AdminFormElement::date('created_at', 'Дата публикации')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::image('image', 'Превью картинка'),
                AdminFormElement::textarea('description', 'Короткое описание')->setRows(3),

            ]))->setLabel('Превью');
            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('slug', 'Алиас'),
                AdminFormElement::text('meta_title', 'Заголовок META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2)->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::text('meta_tags', 'Ключи META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
            ]))->setLabel('SEO');
            return $tabs;
        });
        return AdminForm::form()->addElement($tabs);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
    /**
     * @return FormInterface
     */
    public function onDelete()
    {

    }
}
