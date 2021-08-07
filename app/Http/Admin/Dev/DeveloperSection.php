<?php


namespace App\Http\Admin\Dev;


use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class DeveloperSection
 *
 *
 *
 * @package App\Http\Admin\Dev
 */

class DeveloperSection extends Section implements Initializable
{


    public function initialize()
    {
        /*
         * Вызывать родительский метод после потомка!
         */
        $this->alias = "dev/".$this->alias;
        $this->title = $this->title.' (Режим разработчика)';
        $this->icon = 'fa fa-terminal';
    }

    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->dev;
    }

    /**
     * @return FormInterface
     */
    public function onEdit()
    {

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
