<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'notification_emails' => 'array'
    ];

    protected $attributes = [
        'notification_emails' => '[]'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function($site){
            if (in_array('default', array_keys($site->getDirty()))) {
                $site->user->sites()->whereNot('id', $site->id)->update(['default' => false]);
            }
        });
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function endpoints():HasMany
    {
        return $this->hasMany(Endpoint::class)
            ->withCount(['checks as successful_checks_count' => function($q){
                $q->where('response_code', '>=', 200)->where('response_code', '<', 300);
            }])->latest();
    }

    public function url() 
    {
        return "$this->scheme://$this->domain";    
    }

    public function name()
    {
        $parsed_url = parse_url($this->domain);

        $host_parts = explode('.', $parsed_url['host']);

        return $host_parts[1];
    }

}
