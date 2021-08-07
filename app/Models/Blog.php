<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;
use App\Traits\{ArticleModel, MetaContainerTrait};

class Blog extends Model implements IEditable, IDisplayable, IMetaContainer, ITextVariablesContainer
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
        return route('blog.show',['slug'=>$this->slug]);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
