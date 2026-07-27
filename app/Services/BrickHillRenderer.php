<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BrickHillRenderer
{
    private $lastError;

    public function render(array $avatar, int $size = 375): ?string
    {
        $this->lastError = null;
        $url = config('site.renderer.url');
        $key = config('site.renderer.key');

        if (!$url) {
            $this->lastError = 'Renderer URL is not configured.';
            Log::warning('Renderer URL is not configured.');
            return null;
        }

        $this->publishItemMetadata($avatar);

        $payload = json_encode([
            'avatarJSON' => json_encode($avatar),
            'size' => $size
        ]);

        $body = false;
        $status = 0;
        $error = '';

        for ($attempt = 1; $attempt <= 2; $attempt++) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-Access-Key: ' . $key
                ]
            ]);

            $body = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($body !== false && $status >= 200 && $status < 300)
                break;

            if (!in_array($status, [0, 502, 503, 504]) || $attempt == 2)
                break;

            sleep(5);
        }

        if ($body === false || $status < 200 || $status >= 300) {
            $response = is_string($body) ? trim(substr($body, 0, 300)) : '';
            $this->lastError = "Renderer HTTP {$status}";

            if ($error)
                $this->lastError .= ": {$error}";
            else if ($response)
                $this->lastError .= ": {$response}";

            Log::warning('Renderer request failed.', [
                'status' => $status,
                'error' => $error,
                'response' => $response
            ]);

            return null;
        }

        $response = json_decode($body);
        $image = $response->image ?? $response->thumbnail ?? null;

        if (!is_string($image) || base64_decode($image, true) === false) {
            $this->lastError = 'Renderer returned JSON without a valid Base64 image.';
            Log::warning('Renderer returned an invalid image response.');
            return null;
        }

        return $image;
    }

    public function lastError(): ?string
    {
        return $this->lastError;
    }

    private function publishItemMetadata(array $avatar): void
    {
        $items = $avatar['items'] ?? [];
        $ids = array_merge(
            $items['hats'] ?? [],
            [
                $items['face'] ?? 0,
                $items['head'] ?? 0,
                $items['tool'] ?? 0,
                $items['pants'] ?? 0,
                $items['shirt'] ?? 0,
                $items['figure'] ?? 0,
                $items['tshirt'] ?? 0
            ]
        );

        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if (empty($ids))
            return;

        $storage = Storage::disk('local');

        foreach (Item::whereIn('id', $ids)->get() as $item) {
            $mesh = "{$item->filename}.obj";
            $sourceMesh = "uploads/{$item->filename}.obj";
            $publicMesh = "uploads/{$item->filename}_mesh.png";

            if ($storage->exists($sourceMesh)) {
                $storage->put($publicMesh, $storage->get($sourceMesh));
                $mesh = "{$item->filename}_mesh.png";
            }

            $storage->put("renderer/items/{$item->id}.png", json_encode([[
                'mesh' => "asset://{$mesh}",
                'texture' => "asset://{$item->filename}.png"
            ]]));
        }
    }

    public function emptyAvatar(int $userId = 0): array
    {
        return [
            'user_id' => $userId,
            'items' => [
                'face' => 0,
                'hats' => [0, 0, 0, 0, 0],
                'head' => 0,
                'tool' => 0,
                'pants' => 0,
                'shirt' => 0,
                'figure' => 0,
                'tshirt' => 0
            ],
            'colors' => [
                'head' => 'f3b700',
                'torso' => 'c60000',
                'left_arm' => 'f3b700',
                'right_arm' => 'f3b700',
                'left_leg' => '650013',
                'right_leg' => '650013'
            ]
        ];
    }
}
