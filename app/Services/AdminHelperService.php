<?php

namespace App\Services;

class AdminHelperService
{
    public static function GetTextVariablesHelp()
    {
        $sections = [];
        //Load global variables
        foreach (config("variables") ?? [] as $item) {
            $sections[$item['section']] = (object)$item;
        }
        //load custom variables
        foreach (config("variables_custom") ?? [] as $item) {
            if (isset($sections[$item['section']])) {
                foreach ($item['variables'] as $var_name => $var_desc)
                    $sections[$item['section']]->variables[$var_name] = $var_desc;
            }
            else
            {
                $sections[$item['section']] = (object)$item;
            }
        }
        //load user variables
        if (class_exists("App\Models\Correct"))
        {
            $item = [
                "section" => "user",
                "title" => "Пользовательские",
                "description" => 'Переменные автозамены',
                "icon" => "fa fa-random",
                "variables" =>[]
            ];
            foreach (\App\Models\Correct::all() as $var)
            {
                $item['variables']['%'.$var->key.'%'] =  $var->name;
            }
            $sections['user'] = (object)$item;
        }
        return $sections;
    }
}
