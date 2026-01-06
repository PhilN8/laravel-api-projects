<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterface;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $completed
 * @property null|CarbonInterface $completed_at
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'completed', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime'
    ];
}
