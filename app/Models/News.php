<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;
use App\Traits\{ArticleModel, MetaContainerTrait};

class News extends Model implements IDisplayable, IEditable, IMetaContainer, ITextVariablesContainer
{
    use ArticleModel;
    use OrderableModel;
    use MetaContainerTrait;

    protected $casts = [
        'fields' => 'array',
    ];
    public function scopeFindByPosition($query, $position)
    {
        return $query->where($this->getOrderField(), $position);
    }
    public function getUrl()
    {
        return route('news.show',['slug'=>$this->slug]);
    }
}
