<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    /**
     * @param int $bill_id
     * @param array $params
     * @return array
     */
    public static function getCardsByBillId($bill_id = 0, $params = [])
    {
        if (!$bill_id) {
            return [];
        }

        $card_list = Card::select("id", "bill_id", "number", "type", "active")
            ->where('bill_id', '=', $bill_id)
            ->offset(!empty($params["offset_start"]) ? $params["offset_start"] : null)
            ->limit(!empty($params["limit"]) ? $params["limit"] : null)
            ->get()
            ->toArray();
        return $card_list;
    }
}
