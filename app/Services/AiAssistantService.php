<?php

namespace App\Services;

/**
 * AI Business Assistant.
 *
 * Uses an external AI provider (Anthropic Claude) when ANTHROPIC_API_KEY is
 * configured. If no key is present, or the request fails for any reason,
 * the service transparently falls back to a rule-based generator so the
 * feature always stays demoable without external dependencies.
 */
class AiAssistantService
{
    public function generateCaption(string $productName, ?string $description, ?string $targetCustomer): array
    {
        $prompt = "Buatkan 1 caption promosi produk UMKM yang menarik dan singkat (maks 60 kata) dalam Bahasa Indonesia untuk produk berikut.\n"
            ."Nama produk: {$productName}\n"
            .'Deskripsi: '.($description ?: '-')."\n"
            .'Target pelanggan: '.($targetCustomer ?: 'umum')."\n"
            .'Gunakan gaya bahasa yang ramah dan persuasif, boleh tambahkan emoji secukupnya.';

        return $this->callAi($prompt, fn () => $this->fallbackCaption($productName, $targetCustomer));
    }

    public function generateContentIdeas(string $businessType, string $product): array
    {
        $prompt = "Berikan 5 ide konten promosi media sosial singkat (dalam bentuk list) untuk usaha jenis \"{$businessType}\" dengan produk unggulan \"{$product}\". Jawab dalam Bahasa Indonesia, setiap ide maksimal 1 kalimat.";

        return $this->callAi($prompt, fn () => $this->fallbackContentIdeas($businessType, $product));
    }

    public function generateDescription(string $productName, ?string $keywords): array
    {
        $prompt = "Tuliskan deskripsi produk yang menarik dan informatif (2-3 kalimat) dalam Bahasa Indonesia untuk produk \"{$productName}\"."
            .($keywords ? " Sertakan kata kunci: {$keywords}." : '');

        return $this->callAi($prompt, fn () => $this->fallbackDescription($productName, $keywords));
    }

    public function generatePromotionStrategy(string $businessType): array
    {
        $prompt = "Berikan 4 ide strategi promosi sederhana dan murah (dalam bentuk list) yang cocok untuk UMKM jenis \"{$businessType}\" agar bisa naik kelas secara digital. Jawab dalam Bahasa Indonesia.";

        return $this->callAi($prompt, fn () => $this->fallbackPromotionStrategy($businessType));
    }

    protected function callAi(string $prompt, \Closure $fallback): array
    {
        $apiKey = config('services.anthropic.key');

        if (! $apiKey) {
            return ['text' => $fallback(), 'is_fallback' => true];
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->timeout(15)->post('https://api.anthropic.com/v1/messages', [
                'model' => config('services.anthropic.model', 'claude-3-5-haiku-20241022'),
                'max_tokens' => 400,
                'messages' => [['role' => 'user', 'content' => $prompt]],
            ]);

            if ($response->successful()) {
                $text = collect($response->json('content'))->pluck('text')->filter()->implode("\n");

                if (! empty(trim($text))) {
                    return ['text' => trim($text), 'is_fallback' => false];
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return ['text' => $fallback(), 'is_fallback' => true];
    }

    protected function fallbackCaption(string $productName, ?string $targetCustomer): string
    {
        $audience = $targetCustomer ?: 'kamu';

        return "✨ {$productName} siap menemani hari-hari {$audience}! Dibuat dengan bahan pilihan dan penuh cinta oleh UMKM lokal. Yuk pesan sekarang sebelum kehabisan! 🛍️ #ProdukLokal #DukungUMKM";
    }

    protected function fallbackContentIdeas(string $businessType, string $product): string
    {
        $ideas = [
            "Behind the scenes proses pembuatan {$product} di usaha {$businessType} Anda.",
            "Testimoni pelanggan yang sudah mencoba {$product}.",
            "Tips atau cara menikmati/menggunakan {$product} dengan cara unik.",
            "Promo spesial akhir pekan untuk {$product}.",
            "Cerita di balik berdirinya usaha {$businessType} Anda (storytelling brand).",
        ];

        return collect($ideas)->map(fn ($idea, $i) => ($i + 1).". {$idea}")->implode("\n");
    }

    protected function fallbackDescription(string $productName, ?string $keywords): string
    {
        $extra = $keywords ? " Cocok untuk {$keywords}." : '';

        return "{$productName} adalah produk unggulan UMKM lokal yang dibuat dengan bahan berkualitas dan proses yang terjaga kebersihannya.{$extra} Nikmati cita rasa/kualitas terbaik langsung dari produsen lokal.";
    }

    protected function fallbackPromotionStrategy(string $businessType): string
    {
        $ideas = [
            "Aktifkan Digital Store LOKALIN dan sebarkan QR Code di lokasi usaha {$businessType} Anda.",
            'Posting produk secara rutin (2-3 kali seminggu) di media sosial dengan foto yang menarik.',
            'Berikan promo bundling atau diskon kecil untuk pembelian pertama lewat LOKALIN.',
            'Ajak pelanggan yang puas untuk memberi review di Digital Store Anda.',
        ];

        return collect($ideas)->map(fn ($idea, $i) => ($i + 1).". {$idea}")->implode("\n");
    }
}
