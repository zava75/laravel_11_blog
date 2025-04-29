<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|mixed
     */

    protected $fillable = [
        'name', 'slug', 'title', 'description', 'article', 'image', 'user_id', 'category_id', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value) {
                    return Str::slug($value);
                }
                return Str::slug($this->name ?? '');
            }
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
