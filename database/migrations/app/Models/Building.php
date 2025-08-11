<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Building extends Model {

    protected $fillable = ['address', 'min_latitude', 'max_latitude', 'min_longitude', 'max_longitude', 'organization_id'];

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function getByCoords($latitude, $longitude) {
        return $this
                        ->where('min_latitude', '<', $latitude)
                        ->where('max_latitude', '>', $latitude)
                        ->where('min_longitude', '<', $longitude)
                        ->where('max_longitude', '>', $longitude)
                        ->get();
    }

    public function setTestData() {
        $this->insert([
            [
                'address' => 'г. Москва, ул. Ленина 1, офис 3',
                'min_latitude' => 33,
                'max_latitude' => 80,
                'min_longitude' => 40,
                'max_longitude' => 66,
                'organization_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'г. Москва, ул. Ленина 5, офис 9',
                'min_latitude' => 45,
                'max_latitude' => 70,
                'min_longitude' => 30,
                'max_longitude' => 56,
                'organization_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'г. Москва, ул. Ленина 9, офис 15',
                'min_latitude' => 13,
                'max_latitude' => 22,
                'min_longitude' => 50,
                'max_longitude' => 73,
                'organization_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
