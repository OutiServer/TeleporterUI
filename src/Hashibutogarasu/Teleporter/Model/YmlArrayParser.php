<?php

namespace Hashibutogarasu\Teleporter\Model;

class YmlArrayParser
{
    public static int $itemscount = 0;
    public static int $childitemscount = 0;
    public static array $array = array();
    public static array $current_item;

    public static int $index;

    public function __construct($data)
    {
        YmlArrayParser::$array = $data;
        YmlArrayParser::$childitemscount = count($data) - YmlArrayParser::$itemscount;
    }

    public static function getSelecteditem($index) : array{
        $selected_item = YmlArrayParser::$array[$index];
        return $selected_item;
    }
}
