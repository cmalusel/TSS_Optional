<?php

use PHPUnit\Framework\TestCase;
use src\ShippingCalculator;
use src\Box;

class ShippingCalculatorTest extends TestCase
{
    private  $shippingCalculator;

    public function testItShouldThrowErrorWhenNegativeValuesAreInserted()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->shippingCalculator->calculatePriceAccordingToSizeAndWeight(-1, -1, -1, -1);

    }

    public function testItShouldReturnMinimumCharge() {
        $total = $this->shippingCalculator->calculatePriceAccordingToSizeAndWeight(10.0, 10.0, 10.0, 1);

        $this -> assertEquals(15.0, $total);
    }

    public function testItShouldReturnCorrectPrice() {
        $total = $this->shippingCalculator->calculatePriceAccordingToSizeAndWeight(20.0, 20.0, 20.0, 10);

        $this -> assertEquals(20.0, $total);
    }
    public function testItShouldReturnCorrectIncreasedPriceBasedOnType() {
        $total = $this->shippingCalculator->calculatePriceAccordingToSizeAndWeight(20.0, 20.0, 20.0, 10, "express");

        $this -> assertEquals(26.0, $total);
    }

    public function testItShouldSelectAnEmptyBox() {
        $box = $this->shippingCalculator->selectLockerBox(20.0, 20.0, 20.0);

        $this->assertEquals(new Box(40, 30, 20, true), $box);
    }

    public function testItShouldNotFindAnBox() {
        $this->expectException(Exception::class);
        $box = $this->shippingCalculator->selectLockerBox(200.0, 200.0, 200.0);

    }


    protected function setUp(): void
    {
        $this->shippingCalculator = new ShippingCalculator();
    }

    protected function tearDown(): void
    {
        $this->shippingCalculator = null;
    }
}
