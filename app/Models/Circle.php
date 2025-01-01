<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Circle extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'circle_users');
    }
}
