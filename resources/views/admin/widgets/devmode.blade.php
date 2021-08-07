<li class="dropdown fast-actions">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="hidden-xs">
                <i class="fa fa-code"></i>
                Обслуживание
            </span>
    </a>
    <ul class="dropdown-menu">
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="{{ route('admin.dev.clear.config') }}">
                <i class="fa fa-btn fa-cogs"></i> Очистить кэш конфигурации
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dev.clear.view') }}">
                <i class="fa fa-btn fa-eye"></i> Очистить кэш шаблонов
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dev.clear.route') }}">
                <i class="fa fa-btn fa-code-fork"></i> Очистить кэш роутов
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dev.clear.cache') }}">
                <i class="fa fa-btn fa-dashboard"></i> Очистить общий кэш
            </a>
        </li>

		<li>
            <a href="{{ route('admin.dev.optimize') }}">
                <i class="fa fa-btn fa-cloud"></i> Оптимизировать
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="{{ route('admin.dev.migrate') }}">
                <i class="fa fa-btn fa-table"></i> Мигрировать таблицы
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="{{ route('admin.dev.product.images.rename') }}">
                <i class="fa fa-btn fa-pencil"></i> Переименовать изображения
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dev.product.images.optimize') }}?compress=1">
                <i class="fa fa-btn fa-archive"></i> Сжать изображения
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dev.product.images.optimize') }}?flush=1">
                <i class="fa fa-btn fa-archive"></i> Уменьшить изображения
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="{{ route('admin.dev.check.sitemap') }}">
                <i class="fa fa-btn fa-code-fork"></i> Диагностика Sitemap
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="/admin/devmode/{{access()->dev? 0 : 1}}">
                <i class="fa fa-btn fa-code"></i> Режим разработчика
                @if(access()->dev)
                    <span class="badge">ON</span>
                @endif
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
    </ul>
</li>
