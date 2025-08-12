<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class);
    }

    public function building(): BelongsTo {
        return $this->belongsTo(Building::class);
    }

    public function getActivitiesByOrganization() {
        $data = [];

        
        $data[$this->title]['activity'] = $this->activity;
        

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
                'activity_id' => 1,
                'building_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Рога и копыта2',
                'phones' => json_encode([89999999999, 89999983999]),
                'activity_id' => 1,
                'building_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Рога и копыта3',
                'phones' => json_encode([89999799999, 89999943999]),
                'activity_id' => 9,
                'building_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
             [
                'title' => 'Рога и копыта4',
                'phones' => json_encode([89999799999, 89999943999]),
                'activity_id' => 9,
                'building_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
