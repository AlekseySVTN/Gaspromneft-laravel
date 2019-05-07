<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * Class APIBaseController
 * @package App\Http\Controllers
 */
class APIBaseController extends Controller
{
    const ERROR_CODE_SOMEERROR = 1;
    const ERROR_CODE_AUTH = 2;
    const ERROR_CODE_NOT_AVAILABLE = 3;
    const ERROR_CODE_NOT_EXIST = 4;
    const ERROR_CODE_SERVER_PROBLEM = 5;

    /**
     * Текст ошибок
     * @var array
     */
    protected static $error_messages = [
        self::ERROR_CODE_AUTH => "Auth Error",
        self::ERROR_CODE_NOT_AVAILABLE => "You have not permission to this object",
        self::ERROR_CODE_NOT_EXIST => "Not existing object",
        self::ERROR_CODE_SOMEERROR => "SORRY, SOME ERROR",
        self::ERROR_CODE_SERVER_PROBLEM => "We have a problem on server",
    ];

    /**
     * Ответ по умолчанию
     * @return array
     */
    protected static function getDefaultResponseArray()
    {
        return [
            'response' => false,
            'errorcode' => null,
            'errormessage' => ''
        ];
    }
}
