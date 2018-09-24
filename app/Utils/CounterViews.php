<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/24/2018
 * Time: 12:08 PM
 */

namespace App\Utils;

use Illuminate\Http\Request;
use App\Models\CountViews;

class CounterViews
{
    function __construct() {}

    public function counter($id, $type)
    {
        $count = CountViews::where('type', $type)->where('id_item', $id)->first();
        if ($count)
        {
            $count->count++;
            $count->save();
        }
        else
        {
            CountViews::create([
                'type'    => $type,
                'id_item' => $id,
                'count'   => 1
            ]);
        }
    }
}