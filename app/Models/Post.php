<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'author_id',
        'slug',
        'published'
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function user(): User
    {

        return $this->belongsTo(User::class, 'author_id')->first();
    }

    public function canBeLikedByUser(User $user): bool
    {
        return !$this->likes()->where('user_id', $user->id)->count();
    }

    public function getUserLike(User $user): ?Like
    {
        return $this->likes()->where('user_id', $user->id)->first();
    }

    public static function getPublicPosts(int $limit = 0): Collection
    {
        return self::where('published', 1)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getVisiblePosts(int $userId): Collection
    {
        return self::where('published', 1)
            ->orWhere('author_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getSinglePost(string $slug, ?User $user): ?self
    {
        $post = Post::where('slug', $slug)->get()->first();

        if(!$post) {
            return null;
        }

        if($post->published === 1 || $user->id === $post->author_id) {
            return $post;
        }

        return null;
    }




}
