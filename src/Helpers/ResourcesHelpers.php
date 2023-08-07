<?php

use marcusvbda\vstack\Audits;

class ResourcesHelpers
{
    static function minify($htmlString)
    {
        $replace = [
            '<!--(.*?)-->' => '', //remove comments
            "/<\?php/" => '<?php ',
            "/\n([\S])/" => '$1',
            "/\r/" => '', // remove carriage return
            "/\n/" => '', // remove new lines
            "/\t/" => '', // remove tab
            "/\s+/" => ' ', // remove spaces
        ];
        return preg_replace(array_keys($replace), array_values($replace), $htmlString);
    }

    static function all()
    {
        $path = app_path("Http/Resources/");
        $data = [];
        foreach (glob($path . "*.php") as $filename) {
            if (basename($filename) != "Resource.php") {
                $name = str_replace(".php", "", basename($filename));
                $resource = self::make($filename, $name);
                if ($resource->canViewList()) @$data[$resource->menu()][] = $resource;
            }
        }
        return $data;
    }

    static function _all()
    {
        $path = app_path("Http/Resources/");
        $data = [];
        foreach (glob($path . "*.php") as $filename) {
            if (basename($filename) != "Resource.php") {
                $name = str_replace(".php", "", basename($filename));
                $resource = self::make($filename, $name);
                @$data[$resource->menu()][] = $resource;
            }
        }
        return $data;
    }

    static function make($filename)
    {
        $name = str_replace(".php", "", basename($filename));
        $class = "App\\Http\\Resources\\" . $name;
        return App::make($class);
    }
    static function find($name)
    {
        if ($name === "audits") {
            return  App::make(Audits::class);
        }

        $groups = self::_all();
        $_resource = null;
        foreach ($groups as $resources) {
            foreach ($resources as $resource) {
                if ($resource->id == $name)  return $resource;
            }
        }
        if (!$_resource) abort(404);
        return $_resource;
    }
    static function sortLink($route, $query, $field, $type)
    {
        $str_query = "";
        $query["order_by"] = $field;
        $query["order_type"] = $type;
        foreach ($query as $key => $value) {
            $str_query .= $key . "=" . $value . "&";
        }
        $str_query = substr($str_query, 0, -1);
        return $route . "?" . $str_query;
    }
    static function hasFilter($query, $filters = [])
    {
        $keys = array_keys($query);
        $qty = 0;
        foreach ($keys as $key) {
            if (
                self::findFilter($key, $filters) &&
                @$query[$key] &&
                @$query[$key] != "false" &&
                @$query[$key] != "null"
            ) $qty++;
        }
        return $qty;
    }
    static function findFilter($key, $filters)
    {
        foreach ($filters as $f) {
            if ($f->index == $key) return $f;
        };
        return false;
    }
}
