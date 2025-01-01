<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'description',
        'report_date',
        'post_category_id',
        'i_am_hard',
        'knowing_by',
        'happend_now',
        'location',
        'langitude',
        'langitude',
        'status',
        'created_at',
    ];
    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_category_id' => 'integer',
        'langitude' => 'string',
        'langitude' => 'string',
    ];

    protected $appends = [
        'user_reach',
        'total_like',
        'total_dislike'
    ];

    public function getTotalLikeAttribute()
    {
        return $this->reaches ? $this->reaches->where('status', 'like')->count() : 0;
    }

    public function getTotalDislikeAttribute()
    {
        return $this->reaches ? $this->reaches->where('status', 'dislike')->count() : 0;
    }

    public function getUserReachAttribute()
    {
        $user = auth('api')->user();
        if (!$user || !$this->reaches) {
            return "none";
        }
        $reach = $this->reaches->where('user_id', $user->id)->first();
        return $reach ? $reach->status : "none";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function postImages(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }
    public function postCategtory()
    {
        return $this->hasOne(PostCategory::class, 'id', 'post_category_id');
    }

    public static function scopeNearby($lat, $long, $cat)
    {
        $date = date('Y-m-d H:i:s', strtotime('-48 hours'));
        $posts = self::query()->with(['postCategtory:id,name,image', 'postImages:id,post_id,image']);
        if ($lat != 0 && $long != 0) {
            $posts = $posts->whereRaw("6371 * acos( cos( radians($lat))
            * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians($long) )
            + sin( radians($lat) )
            * sin( radians( latitude ) ) ) <= 5");
        }
        $posts = $posts->where('created_at', '>', $date);
        $posts = $posts->where('status', 1);
        $posts = $posts->orderBy('id', 'desc');
        if ($cat != 0) {
            $posts = $posts->where('post_category_id', $cat);
        }
        $posts = $posts->get();
        return $posts;
    }
    public function reaches(): HasMany
    {
        return $this->hasMany(Reach::class);
    }
}
