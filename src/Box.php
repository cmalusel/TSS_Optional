<?php

namespace src;

class Box
{
    public float $length;
    public float $width;
    public float $height;
    public bool $isOccupied;

    public function __construct(float $length, float $width, float $height, bool $isOccupied = false)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->isOccupied = $isOccupied;
    }

}
