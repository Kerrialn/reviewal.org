<?php

namespace App\Service;

final class GeneralRatingCalculatorService
{
    private const BUILDING_RATING_WEIGHT = 1;
    private const PRICE_RATING_WEIGHT = 1;
    private const MANAGEMENT_RATING_WEIGHT = 1;
    private const LOCATION_RATING_WEIGHT = 1;
    private const TRANSPORT_RATING_WEIGHT = 1;

    public function calculate(
        float $buildingRating,
        float $priceRating,
        float $managementRating,
        float $locationRating,
        float $transportRating,
    ): string
    {
       $weightedbuildingRating = $buildingRating * self::BUILDING_RATING_WEIGHT;
       $weightedPriceRating = $priceRating * self::PRICE_RATING_WEIGHT;
       $weightedManagementRating = $managementRating * self::MANAGEMENT_RATING_WEIGHT;
       $weightedLocationRating = $locationRating * self::LOCATION_RATING_WEIGHT;
       $weightedTransportRating = $transportRating * self::TRANSPORT_RATING_WEIGHT;
        return (string) round($weightedbuildingRating + $weightedPriceRating + $weightedManagementRating + $weightedLocationRating + $weightedTransportRating, 1) / 5;
    }

}
