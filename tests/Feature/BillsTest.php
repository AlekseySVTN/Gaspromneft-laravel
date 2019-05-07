<?php

namespace Tests\Feature;

use App\Http\Controllers\APIBaseController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BillsTest extends TestCase
{
    /**
     * Авторизуется и запрашивает свои данные
     *
     * @return void
     */
    public function testBillByLogin()
    {
        $auth = $this->call('POST', '/auth', ["login" => "zxc_off@mail.ru", "password" => "salamandra"]);

        $bills = $this->json('GET', '/bills', ["login" => "zxc_off@mail.ru"]);
        $bills->assertExactJson([
            'errorcode'=> null,
            'errormessage'=> "",
            'response' => []
        ]);
    }

    /**
     * Авторизуется и запрашивает чужие данные
     *
     * @return void
     */
    public function testBillByGaijinLogin()
    {
        $auth = $this->call('POST', '/auth', ["login" => "zxc_off@mail.ru", "password" => "salamandra"]);

        $bills = $this->json('GET', '/bills', ["login" => "111"]);
        $bills->assertExactJson([
            'errorcode'=> APIBaseController::ERROR_CODE_NOT_EXIST,
            'errormessage'=> "Not existing object user",
            'response' => false
        ]);
    }
}
