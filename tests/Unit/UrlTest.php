<?php

namespace Tests\Unit;

use App\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_an_exception_when_not_an_url()
    {
        $this->expectException(\InvalidArgumentException::class)    ;
        new Url("not a url");
    }
}
