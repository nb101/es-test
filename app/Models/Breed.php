<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_breeds'
    ];

    protected $casts = [
        'sub_breeds' => 'array',
    ];

    /**
     * Get all users with breed
     */
    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
    }


    public function parks()
    {
        return $this->morphedByMany(Park::class, 'breedable');
    }

}
