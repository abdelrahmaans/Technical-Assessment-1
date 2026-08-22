<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Scope a query to filter by search keyword in title.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, ?string $search)
    {
        if (! empty($search)) {
            return $query->where('title', 'like', '%' . $search . '%');
        }

        return $query;
    }

    /**
     * Scope a query to filter by published status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool|string|null  $isPublished
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query, $isPublished = true)
    {
        if ($isPublished !== null && $isPublished !== '') {
            $status = filter_var($isPublished, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($status !== null) {
                return $query->where('is_published', $status);
            }
        }

        return $query;
    }
}
