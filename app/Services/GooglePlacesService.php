<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class GooglePlacesService
{
    // Store the API key once so every request can reuse the same credential.
    private readonly string $apiKey;

    // Store the API base URL so the endpoint can be changed in one place.
    private readonly string $baseUrl;

    public function __construct()
    {
        // Read the Google Places settings from Laravel's configuration system.
        $this->apiKey = (string) config('services.google_places.key');
        $this->baseUrl = (string) config(
            'services.google_places.base_url',
            'https://maps.googleapis.com/maps/api/place'
        );

        // Fail fast if the API key has not been configured.
        if ($this->apiKey === '') {
            throw new InvalidArgumentException('Google Places API key is not configured.');
        }
    }

    public function getPlaceDetails(string $placeId): array
    {
        // Call the Places Details endpoint for one specific place.
        $response = Http::baseUrl($this->baseUrl)->get('/details/json', [
            'place_id' => $placeId,
            'key' => $this->apiKey,
        ]);

        // Surface HTTP errors immediately instead of hiding them.
        $response->throw();

        // Return the decoded API response to the caller.
        return $response->json();
    }

    public function autocomplete(string $input): array
    {
        // Call the Places Autocomplete endpoint to suggest places as the user types.
        $response = Http::baseUrl($this->baseUrl)->get('/autocomplete/json', [
            'input' => $input,
            'key' => $this->apiKey,
        ]);

        // Surface HTTP errors immediately instead of hiding them.
        $response->throw();

        // Return the decoded API response to the caller.
        return $response->json();
    }
}
