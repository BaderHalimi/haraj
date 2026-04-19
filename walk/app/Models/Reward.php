<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points_cost',
    ];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}
