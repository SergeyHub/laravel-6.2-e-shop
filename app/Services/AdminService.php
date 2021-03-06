<?php

namespace App\Services;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;

class AdminService
{
    public static function setSlug(&$model)
    {
        $class = get_class($model);
        $i = 0;
        while(true) {
            $slug = $model->slug ? $model->slug : Str::slug($model->name, '-');
            if ($i) {
                $slug .= '_'.$i;
            }
            $is = $class::where('slug', $slug)->where('id', '!=', $model->id)->first();
            $i++;
            if (!$is) {
                break;
            }
        }
        if (!$model->slug || $i) {
            $model->slug = $slug;
            $model->save();
        }
    }

    public static function setAlts(&$model)
    {
        $alts = explode("\n", $model->image_alts);
        foreach ($model->images ?? [] as $key => $image) {
            $alt = trim($alts[$key] ?? null);
            if (!$alt) {
                $alt = $model->name;
                if ($key) {
                    $alt .= ' - ' . ($key + 1);
                }
                $alts[$key] = $alt;
            }
        }
        $alts = array_slice($alts, 0, count($model->images));
        $model->image_alts = implode("\n", $alts);
        $model->save();
    }

    public static function setMetaTitle(&$model)
    {
        if (!$model->meta_title) {
            $model->meta_title = $model->name;
            $model->save();
        }
    }
    public static function setValues(&$model)
    {
        $variations = request()->fields;

        $model->variations = $variations;

        $details = request()->details ?? [];
        $model->details = $details;

        $model->save();
    }
    public static function getOrderColumnContent($model,$basePath)
    {
        //dd(get_class($model));
        $class = get_class($model);
        $content = '<span class="hidden">'.$model->order.'</span>';
        if ($model->order > $class::min('order')) {
            $content .= '<form action="'.$basePath.$model->id.'/up" method="POST" style="display:inline-block;">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <button class="btn btn-default btn-sm" data-toggle="tooltip" title="?????????????????? ??????????">
                    ???
                </button>
            </form>';
        }
        $content .= '<form action="'.route('admin.order').'" class="order-form" method="POST" style="display:inline-block;">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="old" value="'.$model->order.'">
                <input type="hidden" name="model" value="'.$class.'">
                <input type="hidden" name="id" value="'.$model->id.'">
                <input class="form-control field-order" type="number" name="new" value="'.$model->order.'">
            </form>';
        if ($model->order < $class::max('order')) {
            $content .= '<form action="'.$basePath.$model->id.'/down" method="POST" style="display:inline-block;">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <button class="btn btn-default btn-sm" data-toggle="tooltip" title="?????????????????? ????????">
                    ???
                </button>
            </form>';
        }
        return $content;
    }
    public static function seoTab()
    {
        $tab = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('slug', '??????????')->setHelpText('?????????? ????????????????. ???????????????? ????????????, ?????????? ?????????????????????????? ??????????????????????????'),
                AdminFormElement::text('meta_title', '?????????????????? META'),
                AdminFormElement::textarea('meta_description', '???????????????? META')->setRows(2),
                AdminFormElement::text('meta_keywords', '?????????? META'),
            ]))->setLabel('SEO');
        return $tab;
    }
    public static function sizeFields()
    {
        $fields = AdminFormElement::columns()
            ->addColumn([AdminFormElement::number('width', '???????????? (????)')])
            ->addColumn([AdminFormElement::number('height', '???????????? (????)')])
            ->addColumn([AdminFormElement::number('depth', '?????????????? (????)')]);
        return $fields;
    }
    public static function descriptionTab($model)
    {

        $tab = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
            AdminFormElement::columns()
                ->addColumn([AdminFormElement::number('width', '???????????? (????)')])
                ->addColumn([AdminFormElement::number('height', '???????????? (????)')])
                ->addColumn([AdminFormElement::number('depth', '?????????????? (????)')]),
            AdminFormElement::html('<div class="col-md-6 col-md-offset-3">'),
            AdminFormElement::ckeditor('description','????????????????'),
            AdminFormElement::html('</div><div class="clearfix"></div>'),

            AdminFormElement::html('<div class="col-md-3">'),
            AdminFormElement::textarea('possibilities','???????? ??????????????????????')
                            ->setHelpText('
                                ???????????? ?????????? ?? ?????????? ????????????.<br>
                                ???????????????? ????????????, ?????? ???? ???????????????????????? <a href="/admin/configs">?????????? ???? ??????????????????</a>'),
            AdminFormElement::html('</div>'),
            AdminFormElement::html('<div class="col-md-6 text-center">'),
            AdminFormElement::image('big_image','?????????????? ????????????????')
                            ->setHelpText('???????????????????????? ?????????? ?????????????????????????? ?? ??????????????????????'),
            AdminFormElement::html('</div>'),
            AdminFormElement::html('<div class="col-md-3">'),
            AdminFormElement::textarea('feature','??????????????????????')
                            ->setHelpText('???????????? ?????????? ?? ?????????? ????????????.'),
            AdminFormElement::html('</div><div class="clearfix"></div>'),
            AdminFormElement::view('admin.imagegrid',['items'=> $model ? $model->details : []]),
            AdminFormElement::image('big_image2','?????????????? ???????????????? 2')
                            ->setHelpText('???????????????????????? ?????????? ??????????????'),
        ]))->setLabel('???????????????? ?? ??????????????????');
        return $tab;
    }
}
