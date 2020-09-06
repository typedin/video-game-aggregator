<?php

namespace Tests\Unit;

use App\ParamsForSocial;
use PHPUnit\Framework\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParamsForSocialTest extends TestCase
{
    /**
     * @test
     */
    public function it_must_be_instanciate_with_the_right_parameters()
    {
        $this->expectExceptionObject(InvalidArgumentException::class);
        $sut = new ParamsForSocial();
    }
}
