@if(breadcrumbs()->length)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb d-none d-sm-flex" itemscope itemtype="http://schema.org/BreadcrumbList">
            @foreach (breadcrumbs()->get() as $item)
                <li class="breadcrumb-item @if ($loop->last)active @endif" itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    @if ($loop->first)
                        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{  $item['href'] }}">
                            <span itemprop="name" class="d-none">
                                {{  $item['name'] }}
                            </span>
                            @svg('images/svg/house.svg')
                        </a>
                    @elseif ($loop->last)
                        <span itemprop="name">
                                  {{  $item['name'] }}
                            </span>
                    @else
                        <a href="{{  $item['href'] }}" itemscope itemtype="http://schema.org/Thing"
                           itemprop="item">
                                <span itemprop="name">
                                    {{  $item['name'] }}
                                </span>
                        </a>
                    @endif
                    <meta itemprop="position" content="{{$loop->index+1}}"/>
                </li>
            @endforeach
        </ol>
    </nav>
@endif


