<?php

Meta::addCss('admin.css', asset('css/admin.css'), ['admin-default']); //!sic :)
Meta::addJs('admin-custom-js', asset('js/admin.js').'?1', ['admin-default']);
Meta::addJs('admin-custom-js-0', asset('packages/sleepingowl/ckeditor/ckeditor.js'), ['admin-default']);
Meta::addJs('admin-custom-js-1', asset('js/jquery-jesse.js'), ['admin-default']);
Meta::addJs('admin-custom-js-2', asset('js/admin-custom.js'), ['admin-default']);
Meta::addJs('admin-custom-js-4', asset('js/manifest.js?7'), ['admin-default']);


//JSON editor
Meta::addJs('json_editor.js', asset('/js/admin/json_editor.js'), ['admin-default']);

//multiselect-tabled editor
Meta::addJs('multiselect-tabled.js', asset('/js/admin/multiselect-tabled.js'), ['admin-default']);

//handsontable
Meta::addJs('handsontable.js', asset('/js/admin/handsontable.full.min.js'), ['admin-default']);
Meta::addCss('handsontable.css', asset('/css/admin/handsontable.full.min.css'), ['admin-default']);

//moment
Meta::addJs('moment.js', asset('/js/admin/moment.min.js'), ['admin-default']);

//boostrap toggle
Meta::addJs('bootstrap-toggle.js', asset('/js/admin/bootstrap-toggle.min.js'), ['admin-default']);
Meta::addCss('bootstrap-toggle.css', asset('/css/admin/bootstrap-toggle.min.css'), ['admin-default']);
