<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller {

    public function __construct(private Organization $organization) {
        
    }

    /**
     * @OA\Post(
     *     path="/api/organizations/get-organization-by-name",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Получение организации по имени",
     *          @OA\JsonContent(
     *             oneOf={
     *                    @OA\Schema(ref="#/components/schemas/Activity"),
     *                   
     *               },

     *          )
     *     ),
     *     @OA\Response(response="200", description="Get organization by name"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function getOrganizationByName(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        $title = $validated['title'];

        return $this->organization->where('title', $title)->with('building')->with('activities')->first();
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/get-organization-info-by-id/{organizationId}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="organizationId", in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Get organization info by id"),
     *     @OA\Response(response="404", description="Model not found")
     * )
     */
    public function getOrganizationInfoById($organizationId) {

        $organization = $this->organization->findOrFail($organizationId);

        $activitiesByOrganization = $organization->getActivitiesByOrganization();

        $buildingByOrganization = $organization->getBuildingByOrganization();

        return array_merge_recursive($activitiesByOrganization, $buildingByOrganization);
    }
}
