<?php

namespace App\Http\Controllers;

use App\Bill;
use Auth;
use App\Card;
use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Driver\Mysqli\MysqliException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CardController extends APIBaseController
{

    public static $on_page = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Card $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCard(Request $request)
    {

        $response = self::getDefaultResponseArray();

        if (Auth::check()) {
            $card_id = $request->input("id_card");
            $redis_key = "card::" . $card_id . "::auth_user::" . Auth::id();
            try {
                $rand = rand(0, 2);
                if ($rand) {
                    throw new MysqliException("Игра в имитацию");
                }

                $card_data = Card::find($card_id);

                if ($card_data) {
                    $bill_data = Bill::find($card_data->bill_id);
                    if ($bill_data && $bill_data->user_id == Auth::id()) {
                        $response['response'] = $card_data;
                    } else {
                        if ($bill_data && $bill_data->user_id != Auth::id()) {
                            $response['errormessage'] =  self::$error_messages[self::ERROR_CODE_NOT_AVAILABLE]." bill for this user";
                            $response['errorcode'] = self::ERROR_CODE_NOT_AVAILABLE;
                        } else {
                            $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_EXIST]." bill";
                            $response['errorcode'] = self::ERROR_CODE_NOT_EXIST;
                        }
                    }
                } else {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_EXIST]." card";
                    $response['errorcode'] = self::ERROR_CODE_NOT_EXIST;
                }

                Redis::set($redis_key, json_encode($response));
            } catch (MysqliException $e) {
                Log::error("ERROR!");
                if (Redis::exists($redis_key)) {
                    $response = json_decode(Redis::get($redis_key), true);
                    $response["addintional"] = "from_cache";
                } else {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_SERVER_PROBLEM];
                    $response['errorcode'] = self::ERROR_CODE_SERVER_PROBLEM;
                }
            }

        } else {
            $response['errormessage'] = self::$error_messages[self::ERROR_CODE_AUTH];
            $response['errorcode'] = self::ERROR_CODE_AUTH;
        }


        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCardLists(Request $request)
    {


        $page = $request->input("page") ? $request->page : 1;


        $params = [
            "offset_start" => ($page - 1) * self::$on_page,
            "limit" => self::$on_page,
        ];


        $response = self::getDefaultResponseArray();

        if (Auth::check()) {
            $bill_id = $request->input("id_bill");
            $bill_data = Bill::find($bill_id);

            if ($bill_data && $bill_data->user_id == Auth::id()) {
                $card_list = Card::getCardsByBillId($bill_id, $params);
                $response['response'] = $card_list;
            } else {
                if ($bill_data && $bill_data->user_id != Auth::id()) {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_AVAILABLE]. " bill for this user";
                    $response['errorcode'] = self::ERROR_CODE_NOT_AVAILABLE;
                } else {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_EXIST]." bill";
                    $response['errorcode'] = self::ERROR_CODE_NOT_EXIST;
                }
            }
        } else {
            $response['errormessage'] = self::$error_messages[self::ERROR_CODE_AUTH];
            $response['errorcode'] = self::ERROR_CODE_AUTH;
        }


        return response()->json($response, 200);
    }
}
