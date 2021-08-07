<?php


namespace App\Http\Admin\Form\Element;

use App\Services\ImageOptimizer;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Form\Element\Image;

class ImageImproved extends Image
{
    protected $view = 'form.element.image-improved';
    public function saveFile(UploadedFile $file, $path, $filename, array $settings)
    {
        if (is_callable($callback = $this->getSaveCallback())) {
            return $callback($file, $path, $filename, $settings);
        }
        $file->move($path, $filename);

        //S3 Implement
        $value = $path.'/'.$filename;
        ImageOptimizer::Auto($value,true,false);
        return ['path' => asset($value), 'value' => $value];
    }

}