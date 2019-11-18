<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Autonumber
{
    /**
     * @param string Module
     *
     * @return string
     */
    public static function getNextAutonumber($module)
    {
        $number = Autonumber::getNumber($module);
        $nextNumber = sprintf('%07s', ++$number);
        return (isset($nextNumber) ? 'INV-' . $nextNumber : '');
    }
    public static function setNextAutonumber($module) {
        $number = Autonumber::getNumber($module);
        DB::table('autonumber')
            ->where('name', $module)
            ->update(['number' => ++$number]);
    }
    private static function getNumber($module)
    {
        $number = DB::table('autonumber')->where('name', $module)->value('number');
        return $number;
    }
}
