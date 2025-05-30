<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatHelper
{
    public static function dataBrasileira($data)
    {
        return $data ? Carbon::parse($data)->format('d/m/Y') : null;
    }
}
