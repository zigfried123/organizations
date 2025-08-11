<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Organization extends Model {

    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    protected $fillable = ['title', 'phones'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'phones' => AsArrayObject::class,
        ];
    }

    public function activities(): HasMany {
        return $this->hasMany(Activity::class);
    }

    public function building(): HasOne {
        return $this->hasOne(Building::class);
    }

    public function getActivitiesByOrganization() {
        $data = [];

        $activities = $this->activities;

        foreach ($activities as $activity) {

            $data[$this->title]['activities'][] = $activity;
        }

        return $data;
    }

    public function getBuildingByOrganization() {

        $data = [];

        $building = $this->building;

        $data[$this->title]['building'][] = $building;

        return $data;
    }

    public function getOrganizationByName($title) {
        return $this->where('title', $title)->with('building')->with('activities')->first();
    }

    public function setTestData() {
        $this->insert([
            [
                'title' => 'Рога и копыта1',
                'phones' => json_encode([89998899999]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Рога и копыта2',
                'phones' => json_encode([89999999999, 89999983999]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Рога и копыта3',
                'phones' => json_encode([89999799999, 89999943999]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
