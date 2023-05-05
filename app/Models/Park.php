<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    /**
     * Get all users for the park.
     */
    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
    }

    /**
     * Get all breeds for the park.
     */
    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }

}
