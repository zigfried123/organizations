<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     title="Activity",
 *     @OA\Property(property="title", type="string")
 * )
 */
class Activity extends Model {

    protected $fillable = ['title', 'parent_id', 'organization_id'];

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function activities(): HasMany {
        return $this->hasMany(Activity::class, 'parent_id', 'id');
    }

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class, 'id', 'parent_id');
    }

    public function getActivitiesWithoutParent() {
        return $this->where('parent_id', null)->get();
    }

    public function getOrganizationsByActivity($type = null) {
        $activitiesWithoutParent = $this->getActivitiesWithoutParent();

        $data = [];

        foreach ($activitiesWithoutParent as $activity) {

            if (isset($type) && $activity->title !== $type) {
                continue;
            }

            $activitiesLvl2 = $activity->activities;

            foreach ($activitiesLvl2 as $activityLvl2) {

                $data[$activityLvl2->title] = $activityLvl2->organization->title;

                $activitiesLvl3 = $activityLvl2->activities;

                foreach ($activitiesLvl3 as $activityLvl3) {
                    $data[$activityLvl3->title] = $activityLvl3->organization->title;
                }
            }
        }

        return $data;
    }

    public function setTestData() {
        $this->insert([
            [
                'title' => 'Еда',
                'parent_id' => null,
                'organization_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Мясная продукция',
                'parent_id' => 1,
                'organization_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Молочная продукция',
                'parent_id' => 1,
                'organization_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Автомобили',
                'parent_id' => null,
                'organization_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Грузовые',
                'parent_id' => 4,
                'organization_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Легковые',
                'parent_id' => null,
                'organization_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Запчасти',
                'parent_id' => 6,
                'organization_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Аксессуары',
                'parent_id' => 6,
                'organization_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Колбаса',
                'parent_id' => 2,
                'organization_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Кефир',
                'parent_id' => 3,
                'organization_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Газель',
                'parent_id' => 5,
                'organization_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Двигатель',
                'parent_id' => 7,
                'organization_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
