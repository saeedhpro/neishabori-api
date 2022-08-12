<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jcc\LaravelVote\Traits\Votable;

class Comment extends Model
{
    use HasFactory, Votable;

    const TYPE_ARTICLE = 'article';
    const TYPE_PRODUCT = 'product';

    protected $fillable = [
        'accept',
        'type',
        'body',
        'likes',
        'dislikes',
        'user_id',
        'parent_id',
        'commentable_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): BelongsTo
    {
        switch ($this->type) {
            case Comment::TYPE_ARTICLE:
                return $this->article();
            case Comment::TYPE_PRODUCT:
                return $this->product();
        }
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'commentable_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'commentable_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
