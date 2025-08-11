<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller {

    public function __construct(private Building $building) {
        
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/get-organization-by-building",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Cписок всех организаций находящихся в конкретном здании")
     * )
     */
    public function getOrganizationByBuilding() {
        $data = [];

        $buildings = $this->building->with('organization')->get();

        foreach ($buildings as $building) {

            $data[$building->address] = $building->organization->title;
        }

        return $data;
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/get-buildings-by-coords",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="latitude", in="query", @OA\Schema(type="decimal")),
     *     @OA\Parameter(name="longitude", in="query", @OA\Schema(type="decimal")),
     *     @OA\Response(response="200", description="Cписок организаций, которые находятся в заданном радиусе/прямоугольной области относительно указанной точки на карте. список зданий"),
     *     @OA\Response(response="422", description="Ошибка валидации")
     * )
     */
    public function getBuildingsByCoords(Request $request) {

        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];

        $buildingsByCoords = $this->building->getByCoords($latitude, $longitude);

        $data2 = [];

        foreach ($buildingsByCoords as $buildingByCoord) {
            $data2[$buildingByCoord->address] = $buildingByCoord->organization->title;
        }

        return $data2;
    }
}
