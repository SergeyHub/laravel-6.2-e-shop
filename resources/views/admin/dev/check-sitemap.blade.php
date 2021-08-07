<div class="panel">
    <div class="panel-body">
        <p>Тут производится проверка страниц, указанных <a href="/sitemap.xml" target="_blank"><i class="fa fa-code"></i> Sitemap.xml</a>.</p>
        <p>Проверка производитися в 2 этапа: проверка формата ссылок и проверка страниц. Проверки запускаются <b>по отдельности</b>.</p>
        <hr>
        <div id="diag">

        </div>
        <div class="text-center">
            <a class="btn btn-primary check-links" onclick="startLinksChecking()">
                <i class="fa fa-check-square-o"></i>
                Проверить ссылки
            </a>
            <a class="btn btn-primary check-pages" style="display: none" onclick="startPagesChecking()">
                <i class="fa fa-check-square-o"></i>
                Проверить страницы
            </a>
        </div>
        <br>
        <div class="progress">
            <div class="progress-bar" id="progress" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="loader"></div>
    </div>
</div>

