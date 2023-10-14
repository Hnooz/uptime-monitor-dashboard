<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name(),
            'domain' => $this->domain,
            'description' => $this->description,
            'is_connected' => $this->is_connected,
            'endpoints_count' => count($this->endpoints),
            'notification_emails' => $this->notification_emails
        ];
    }
}
