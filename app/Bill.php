<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /**
     * @param int $user_id
     * @return array
     */
    public static function getBillsByUserId($user_id = 0)
    {
        if (!$user_id) {
            return [];
        }

        $bill_list = Bill::select("id", "number", "status")->where('user_id', '=', $user_id)->get()->toArray();
        return $bill_list;
    }
}
