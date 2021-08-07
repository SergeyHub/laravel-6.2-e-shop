<?php

namespace App\Http\Admin;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use Illuminate\Database\Eloquent\Model;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;


/**
 * Class Fronpage
 *
 * @property \App\Models\Frontpage $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Block extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Главная';
        $this->icon = 'fa fa-home';
        $this->creating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $fields = [
                'title' => [
                    'type' => 'text',
                    'title' => 'Заголовок',
                ],
                'title' => [
                    'type' => 'ckeditor',
                    'title' => 'Описание',
                ],

            ];
            //$model->fields = $fields;
        });
        $this->updating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            //-----------------override default updating method----------------------
            //save model name
            $model->name = request()->name;
            //save model dynamic fields
            $model->values = request()->values;
            //commit changes
            $model->save();
            return false;
            //------------------------------------------------------------------------
        });

    }
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */


    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;
    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->content;
    }
    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatables()

            ->setApply(function ($query) {
                $query->where('status',1)->orderBy('order', 'asc');
            })
            ->setColumns([
                AdminColumn::text('name')->setLabel('Название'),
                AdminColumn::text('country.name', 'Страна'),
               /*  \AdminColumnEditable::checkbox('status')->setLabel('Статус'), */
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                AdminColumn::order()->setLabel('Положение'),
            ])
            ->setDisplaySearch(true)
            ->paginate(30);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $item = $id ? \App\Models\Block::find($id) : false;
        $columns = [
            AdminFormElement::html('<p><strong>Страна:</strong> '.$item->country->name.'</p>'),
            AdminFormElement::text('name', 'Административное название блока'),
            /* AdminFormElement::text('slug', 'Алиас'),
            AdminFormElement::text('meta_title', 'Заголовок META'),
            AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2),
            AdminFormElement::text('meta_tags', 'Ключи META'), */
        ];
        if($item) {
            //dd($item->fields);
            foreach($item->fields as $key => $field) {

                $type = $field['type'] ?? '';
                if ($type == 'array') {
                    $html = '<div class="panel panel-primary js-panel-items">
                                <div class="panel-heading">'.$field['title'].'</div>
                                <div class="panel-body js-multi-elements">';
                    $imge_items = [];
                    if (isset($item->values[$key]) && count($item->values[$key])) {
                        foreach ($item->values[$key] as $ki => $velement) {
                            $html .= '<div data-num="' . $ki . '" class="js-multi_item panel panel-success"><div class="panel-body">
                                <button type="button"   class="btn btn-danger btn-sm js-remove-multi-element pull-right">
                                    <i class="fa fa fa-times"></i> Удалить
                                </button>';
                            foreach ($field['item'] as $ks => $element) {
                                $dvalue = isset($velement[$ks]) ? $velement[$ks] : '';
                                $tt = $element['type'];
                                if ($tt == 'image') {
                                    $image_item = AdminFormElement::image('values[' . $key . ']['. $ki .'][' . $ks . ']', 'Изображение '.($ki+1));
                                    $image_item = $image_item->setDefaultValue($dvalue)->setValueSkipped(true);//->setAttribute('class',['.js_remove-element--'.$ki]);
                                    $alt_value = $velement[$ks.'_alt'] ?? '';
                                    $image_alt = AdminFormElement::text('values[' . $key . ']['. $ki .'][' . $ks . '_alt]', 'Альт Изображения '.($ki+1));
                                    $image_alt = $image_alt->setDefaultValue($alt_value)->setValueSkipped(true);//->setAttribute('class',['.js_remove-element--'.$ki]);
                                    $imge_items[] = $image_item;
                                    $imge_items[] = $image_alt;
                                    //$html .= $itm;
                                } else {
                                    $itm = AdminFormElement::$tt('values[' . $key . ']['. $ki .'][' . $ks . ']', $element['title'])->setDefaultValue($dvalue)->setValueSkipped(true);

                                    if ($element['type']=='ckeditor') {
                                        $html .= '<div class="js-next_ck"></div>';
                                        $itm = $itm->setHtmlAttributes(['id' => 'editor_'.$key.'_'.$ki.'_'.$ks,'class'=> ['js-ckeditor']]);
                                    }
                                    $html .= $itm;
                                }
                            }
                            $html .= '</div></div>';
                        }
                    } else {
                        $html .= '<div data-num="0"  class="js-multi_item panel panel-success"><div class="panel-body">
                                <button type="button"  class="btn btn-danger btn-sm js-remove-multi-element pull-right">
                                    <i class="fa fa fa-times"></i> Удалить
                                </button>';
                        foreach ($field['item'] as $ks => $element) {
                            $tt = $element['type'];
                            if ($tt == 'image') {
                               /*  $image_item = AdminFormElement::image('values[' . $key . '][' . $ks . ']', 'Изображение '.($ks+1))->setValueSkipped(true);//->setAttribute('class',['.js_remove-element--'.$ki]);
                                $imge_items[] = $image_item;
                                $imge_items[] = AdminFormElement::text('values[' . $key . '][' . $ks . '_alt]', 'Альт изображения '.($ks+1))->setValueSkipped(true);//->setAttribute('class',['.js_remove-element--'.$ki]); */
                            } else {

                                $html .= AdminFormElement::$tt('values[' . $key . '][0][' . $ks . ']', $element['title'])->setValueSkipped(true);
                            }
                        }
                        $html .= '</div></div>';
                    }
                    $html .= '<button type="button" class="btn btn-success js-add-multi-element"><i class="fa fa-plus"></i> Добавить</button>';
                    $html .= '</div></div>';

                    $columns[] = AdminFormElement::html($html);
                    foreach ($imge_items as $key => $it) {
                        $columns[] = $it;
                    }
                } else {
                    $value = isset($item->values[$key]) ? $item->values[$key] : '';

                    $columns[] = AdminFormElement::$type('values['. $key .']', $field['title'])->setDefaultValue($value)->setValueSkipped(true);
                }
            }
        }
        return AdminForm::panel()->addBody($columns)->setHtmlAttribute('enctype', 'multipart/form-data');

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) {
            $tabs = [];

            $tabs[] = AdminDisplay::tab(AdminForm::elements([
                AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::number('price', 'Цена')->required(),
                AdminFormElement::select('category_id', 'Категория')->setModelForOptions(\App\Models\Category::class)->setDisplay('name')->required(),
                AdminFormElement::select('brand_id', 'Произодитель')->setModelForOptions(\App\Models\Brand::class)->setDisplay('name')->required(),
                AdminFormElement::images('images', 'Изображения'),
            ]))->setLabel('Основное');
            $tabs[] = AdminDisplay::tab(AdminForm::elements([
                AdminFormElement::textarea('complect', 'Комплектация')->setRows(5)->setHelpText('Каждый парамет с новой строки.'),
                AdminFormElement::textarea('feature', 'Особенности')->setRows(5)->setHelpText('Каждый парамет с новой строки.'),
                AdminFormElement::textarea('specification', 'Спецификация')->setRows(5)->setHelpText('Каждый парамет с новой строки.<br>Название и значение разделять | '),
            ]))->setLabel('Параметры');
            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('slug', 'Алиас'),
                AdminFormElement::text('meta_title', 'Заголовок META'),
                AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2),
                AdminFormElement::text('meta_tags', 'Ключи META'),
            ]))->setLabel('SEO');

            return $tabs;
        });
    }
    public function isCreatable()
    {
        return true;
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
