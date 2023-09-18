<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

class Endpoint extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'next_check' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($endpoint){
            $parsed = parse_url("{$endpoint->site->url()}/$endpoint->location");
            $endpoint->location = '/'.trim(Arr::get($parsed, 'path'), '/');
            $endpoint->next_check = now()->addSeconds($endpoint->frequency);
        });
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function check(): HasOne
    {
        return $this->hasOne(Check::class)->latestOfMany();
    }

    public function url(): string
    {
        return $this->site->url() . $this->location;
    }

    public function uptimePercentage(): mixed
    {
        if (!$this->checks->count()) {
            return null;
        }

        return number_format(($this->successful_checks_count / $this->checks->count()) * 100, 2);
    }
}
