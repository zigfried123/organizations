<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller {

    public function __construct(private Activity $activity) {
        
    }

    /**
     * @OA\Get(
     *     path="/api/activities/get-organizations-by-activity",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Cписок всех организаций, которые относятся к указанному виду деятельности")
     * )
     */
    public function getOrganizationsByActivity(Request $request) {
        
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        $title = $validated['title'];

        $organisationsByActivity = $this->activity->getOrganizationsByActivity($title);

        return $organisationsByActivity;
    }

    /**
     * @OA\Post(
     *     path="/api/activities/get-organizations-by-activity-type",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             oneOf={
     *                @OA\Schema(ref="#/components/schemas/Activity"),
     *                   
     *             },
     *          )
     *     ),     
     *     @OA\Response(response="200", description="Искать организации по виду деятельности"),
     *     @OA\Response(response="422", description="Ошибка валидации")
     * )
     */
    public function getOrganizationsByActivityType(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        $type = $validated['title'];

        $organisationsByActivityType = $this->activity->getOrganizationsByActivityType($type);

        return $organisationsByActivityType;
    }
}
