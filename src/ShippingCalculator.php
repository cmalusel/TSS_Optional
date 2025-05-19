<?php

namespace src;

use Exception;
use InvalidArgumentException;

class ShippingCalculator
{
    public function calculatePriceAccordingToSizeAndWeight(
        float $length,
        float $width,
        float $height,
        float $weight,
        string $type = 'standard'
    ): float {
        if ($length <= 0 || $width <= 0 || $height <= 0 || $weight <= 0) {
            throw new InvalidArgumentException("All measurements must be positive numbers.");
        }

        $volume = ($length * $width * $height)/ 1000;

        $ratePerKg = 2.0;
        $ratePerLitre = 2.0;
        $minimumCharge = 15.0;

        $costByWeight = $weight * $ratePerKg;
        $costByVolume = $volume * $ratePerLitre;
        $baseCost = max($costByWeight, $costByVolume);

        // Define surcharges
        $parcelTypes = ['standard', 'fragile', 'oversized', 'perishable', 'express'];
        $surcharges = [0.0, 0.15, 0.25, 0.10, 0.30];
        $surchargeRate = 0.0;

        // Iterate using for loop to find matching type
        for ($i = 0; $i < count($parcelTypes); $i++) {
            if ($parcelTypes[$i] === $type) {
                $surchargeRate = $surcharges[$i];
                break;
            }
        }

        $totalCost = $baseCost * (1 + $surchargeRate);

        if ($totalCost < $minimumCharge) {
            $totalCost = $minimumCharge;
        }

        return $totalCost;
    }


    public function selectLockerBox(
        float $length,
        float $width,
        float $height
    ): Box {

        $boxes = [
            new Box(30, 20, 15, false),
            new Box(25, 25, 20, true),
            new Box(40, 30, 20, false),
            new Box(50, 40, 25, false),
            new Box(60, 50, 30, true),
            new Box(35, 25, 18, false),
            new Box(20, 15, 10, false),
            new Box(45, 35, 22, false),
            new Box(55, 45, 28, true),
            new Box(38, 28, 16, false),
        ];


        $parcel = new Box($length, $width, $height);

        $fits = function (Box $parcel, Box $box): bool {
            return $parcel->length <= $box->length
                && $parcel->width <= $box->width
                && $parcel->height <= $box->height;
        };


        $i = 0;
        $selectedBoxIndex = -1;

        while ($i < count($boxes)) {
            $box = $boxes[$i];

            if (!$box->isOccupied && $fits($parcel, $box)) {
                $selectedBoxIndex = $i;
                $box->isOccupied = true; // mark as occupied
                break;
            }

            $i++;
        }


        if ($selectedBoxIndex >= 0) {
            $selectedBox = $boxes[$selectedBoxIndex];

          return $selectedBox;
        } else {
            throw new Exception('There are no boxes available!');
        }
    }




}