<?php

namespace Tests\Unit;

use App\Helper\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_dataResponse()
    {
        $response = Helper::dataResponse(['test'],1,[]);
        $this->assert('{"[\'code\' ":" \'success","data\' ":" [\'test\']","meta\" ":" [\"total\" ","links\" ":" ","filters\" ":" []]]"}',$response);
    }
}
