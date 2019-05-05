<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AuthController extends APIBaseController
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $response = self::getDefaultResponseArray();

        $email = $request->input("login");
        $password = $request->input("password");
        if ($email && $password && Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // Аутентификация прошла успешно
            $response['response'] = true;
        } else {
            $response["errorcode"] = self::ERROR_CODE_SOMEERROR;
            $response["errormessage"] = self::$error_messages[self::ERROR_CODE_SOMEERROR];
        }
        return response()->json($response, 200);
    }
}