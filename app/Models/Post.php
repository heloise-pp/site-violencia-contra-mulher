<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    // campos preenchíveis
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'excerpt',
        'featured_image_path',
        'is_published',
    ];

    /**
     * relacionamento Postagem - autor
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relacionamento com imagens
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
