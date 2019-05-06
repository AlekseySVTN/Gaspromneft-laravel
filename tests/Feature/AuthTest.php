<?php

namespace Tests\Feature;

use App\Http\Controllers\APIBaseController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    /**
     *
     */
    public function testAuthError(){
        $this->json('POST', '/auth', ['login' => '1','password' => "as"])
            ->assertJson([
                'errorcode' => APIBaseController::ERROR_CODE_SOMEERROR,
            ]);
    }

    /**
     *
     */
    public function testAuthSuccess(){
        $this->json('POST', '/auth', ['login' => 'zxc_off@mail.ru','password' => "salamandra"])
            ->assertJson([
                'errorcode' => null,
                'success' => true,
            ]);
    }
}
