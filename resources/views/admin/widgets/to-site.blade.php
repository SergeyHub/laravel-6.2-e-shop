<li>
    <a href="/" target="_blank">
        <i class="fa fa-level-up"></i>
        На сайт
    </a>
</li>
@if(access()->content)
    <li>
        <a href="{{config("crm.library_address")}}" target="_blank">
            <i class="fa fa-cubes"></i>
           CRM-L
        </a>
    </li>
@endif
