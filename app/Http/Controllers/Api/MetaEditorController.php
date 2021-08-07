<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\IMetaContainer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetaEditorController extends Controller
{

    public function getForm(Request $request)
    {
        $content = view('admin.editor.meta')->render();
        return \AdminSection::view($content, 'Табличное редактирование МЕТА-данных');
    }

    public function valid($class)
    {
        //check model class exists
        if (!class_exists($class)) {
            return false;
        }
        //check model class imlements IMetaContainer interface
        if (!isset(class_implements($class)["App\Interfaces\IMetaContainer"])) {
            return false;
        }
        return true;
    }

    public function getData(Request $request)
    {
        $items = [];
        foreach (config("meta-editor.models") ?? [] as $class => $name) {
            if ($this->valid($class)) {
                foreach ($class::all() as $instance) {
                    $item['class'] = $class;
                    $item['name'] = $name;
                    $item['id'] = $instance->id;
                    $item  = array_merge($item, $instance->metaExport());
                    array_push($items, $item);
                }
            }
        }
        return $items;
    }

    public function postData(Request $request)
    {
        $rows = $request->get("rows", []);
        foreach ($rows as $row) {
            $class = $row[0];
            $item = $class::find($row[2]);
            if ($item) {
                $data = [
                    'path' => $row[4],
                    'title' => $row[5],
                    'description' => $row[6],
                    'keywords' => $row[7],
                    'heading' => $row[3],
                ];
                $item->metaImport($data);
                $item->save();
            }
        }
        return ["status" => 1];
    }
}
