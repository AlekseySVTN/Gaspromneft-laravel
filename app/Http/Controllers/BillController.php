<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Bill;
use Illuminate\Http\Request;

class BillController extends APIBaseController
{
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
     * @param  \App\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBillByUserLogin(Request $request)
    {

        $response = self::getDefaultResponseArray();

        if (Auth::check()) {
            $login = $request->input("login");
            $user = User::findUserByLogin($login);
            if ($user && $user->id == Auth::id()) {
                $bills = Bill::getBillsByUserId($user->id);
                $response['response'] = $bills;
            } else {
                if ($user && $user->id != Auth::id()) {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_AVAILABLE];
                    $response['errorcode'] = self::ERROR_CODE_NOT_AVAILABLE;
                } else {
                    $response['errormessage'] = self::$error_messages[self::ERROR_CODE_NOT_EXIST]." user";
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
