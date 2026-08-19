<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class AiAssistantService
{
    /*
    |--------------------------------------------------------------------------
    | CAPTION PROMOSI
    |--------------------------------------------------------------------------
    */
    public function generateCaption(
        string $productName,
        ?string $description,
        ?string $targetCustomer
    ): array {
        $descriptionText = $description ?: 'Tidak diberikan. Gunakan informasi yang tersedia dan jangan mengarang fakta spesifik.';
        $targetCustomerText = $targetCustomer ?: 'Umum';

        $prompt = <<<PROMPT
Anda adalah konsultan pemasaran digital profesional yang membantu UMKM Indonesia.

Buat materi promosi yang berkualitas tinggi untuk produk berikut.

NAMA PRODUK:
{$productName}

DESKRIPSI PRODUK:
{$descriptionText}

TARGET PELANGGAN:
{$targetCustomerText}

TUGAS:

Buat strategi caption promosi yang dapat langsung digunakan oleh pemilik UMKM.

Analisis terlebih dahulu:
- karakteristik produk
- kebutuhan target pelanggan
- manfaat utama produk
- daya tarik emosional yang relevan
- gaya komunikasi yang sesuai
- peluang agar pelanggan tertarik melakukan pembelian

Kemudian berikan output dengan struktur berikut:

1. HOOK
Buat 3 alternatif kalimat pembuka yang menarik perhatian dalam beberapa detik pertama.

2. CAPTION UTAMA
Buat caption promosi yang detail, natural, persuasif, dan tidak terasa seperti tulisan robot.
Gunakan storytelling ringan jika sesuai.
Jelaskan produk dengan jelas.
Fokus pada manfaat dan alasan pelanggan memilih produk.

3. KEUNGGULAN PRODUK
Berikan 4-6 poin keunggulan berdasarkan informasi yang tersedia.
Jangan mengarang fakta yang tidak diberikan.

4. CALL TO ACTION
Berikan 3 alternatif CTA yang mendorong pelanggan untuk bertanya, melihat katalog, atau melakukan pembelian.

5. HASHTAG
Berikan 10-15 hashtag yang relevan dengan produk, target pelanggan, UMKM, dan lokasi secara umum.

6. ALTERNATIF CAPTION
Buat satu caption alternatif dengan gaya lebih santai dan cocok untuk media sosial.

7. STRATEGI PUBLIKASI
Jelaskan:
- platform yang cocok
- format konten yang disarankan
- waktu publikasi secara umum
- jenis visual yang cocok
- cara meningkatkan engagement

8. SARAN PENGEMBANGAN
Berikan beberapa saran praktis agar pemilik UMKM dapat meningkatkan promosi produknya.

Gunakan Bahasa Indonesia yang:
- profesional
- natural
- komunikatif
- mudah dipahami pemilik UMKM
- persuasif tetapi tidak berlebihan

Jangan menggunakan klaim palsu.
Jangan mengatakan produk sebagai "terbaik", "nomor satu", atau klaim kesehatan tanpa informasi yang mendukung.

Berikan jawaban yang lengkap dan detail.
PROMPT;

        return $this->callAi(
            $prompt,
            fn () => $this->fallbackCaption(
                $productName,
                $targetCustomer
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IDE KONTEN
    |--------------------------------------------------------------------------
    */
    public function generateContentIdeas(
        string $businessType,
        string $product
    ): array {
        $prompt = <<<PROMPT
Anda adalah konsultan content marketing untuk UMKM Indonesia.

Usaha:
{$businessType}

Produk unggulan:
{$product}

Buat strategi ide konten media sosial yang lengkap.

Berikan 10 ide konten yang berbeda.

Untuk setiap ide, gunakan struktur:

1. Judul konten
2. Tujuan konten
3. Konsep
4. Hook
5. Format konten
6. Isi utama
7. CTA
8. Platform yang cocok

Variasikan jenis konten:
- edukasi
- storytelling
- promosi
- testimoni
- behind the scenes
- engagement
- soft selling
- hard selling
- branding
- local pride

Pastikan setiap ide realistis untuk UMKM dengan sumber daya terbatas.

Gunakan Bahasa Indonesia yang natural, praktis, dan mudah diterapkan.
Jangan memberikan ide yang terlalu umum atau berulang.
PROMPT;

        return $this->callAi(
            $prompt,
            fn () => $this->fallbackContentIdeas(
                $businessType,
                $product
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI PRODUK
    |--------------------------------------------------------------------------
    */
    public function generateDescription(
        string $productName,
        ?string $keywords
    ): array {
        $keywordText = $keywords ?: 'Tidak ada kata kunci khusus.';

        $prompt = <<<PROMPT
Anda adalah copywriter profesional untuk marketplace dan digital store UMKM.

Nama produk:
{$productName}

Kata kunci:
{$keywordText}

Buat deskripsi produk yang lengkap, informatif, persuasif, dan SEO-friendly.

Gunakan struktur:

1. Judul produk
2. Ringkasan singkat
3. Deskripsi lengkap
4. Keunggulan produk
5. Manfaat produk
6. Target pelanggan
7. Saran penggunaan
8. Call to action

Gunakan Bahasa Indonesia yang natural dan profesional.

Jangan mengarang spesifikasi seperti:
- berat
- ukuran
- bahan
- kandungan
- sertifikasi
- harga
- klaim kesehatan

jika informasi tersebut tidak diberikan.

Jika informasi tidak tersedia, gunakan penjelasan umum yang aman.

Buat hasil yang cukup detail sehingga dapat langsung digunakan pada halaman produk marketplace atau digital store.
PROMPT;

        return $this->callAi(
            $prompt,
            fn () => $this->fallbackDescription(
                $productName,
                $keywords
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STRATEGI PROMOSI
    |--------------------------------------------------------------------------
    */
    public function generatePromotionStrategy(
        string $businessType
    ): array {
        $prompt = <<<PROMPT
Anda adalah konsultan bisnis dan digital marketing yang membantu UMKM Indonesia naik kelas.

Jenis usaha:
{$businessType}

Buat strategi promosi digital yang komprehensif dan realistis.

Analisis:
- karakteristik usaha
- kemungkinan target pelanggan
- positioning
- channel pemasaran
- strategi konten
- strategi penjualan
- strategi retensi pelanggan
- strategi branding

Kemudian berikan:

1. ANALISIS SINGKAT USAHA

2. TARGET PASAR
Jelaskan beberapa kemungkinan segmen pelanggan.

3. POSITIONING
Jelaskan bagaimana usaha dapat membedakan diri dari pesaing.

4. STRATEGI KONTEN
Berikan minimal 5 strategi konten.

5. STRATEGI MEDIA SOSIAL
Jelaskan strategi untuk Instagram, TikTok, WhatsApp, dan platform relevan lainnya.

6. STRATEGI PENJUALAN
Berikan strategi untuk meningkatkan conversion.

7. STRATEGI PROMO
Berikan beberapa contoh promo yang realistis untuk UMKM.

8. STRATEGI CUSTOMER RETENTION
Jelaskan cara membuat pelanggan kembali membeli.

9. STRATEGI BRANDING
Berikan saran mengenai identitas dan komunikasi brand.

10. RENCANA 30 HARI
Buat roadmap sederhana selama 30 hari yang dapat langsung diterapkan.

11. KPI
Berikan indikator yang dapat digunakan untuk mengukur keberhasilan.

12. PRIORITAS
Tentukan 5 tindakan yang paling penting dilakukan terlebih dahulu.

Gunakan Bahasa Indonesia yang profesional, jelas, praktis, dan detail.

Jangan memberikan strategi yang membutuhkan anggaran besar.
Utamakan strategi yang dapat dilakukan UMKM dengan sumber daya terbatas.
PROMPT;

        return $this->callAi(
            $prompt,
            fn () => $this->fallbackPromotionStrategy(
                $businessType
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CALL AI
    |--------------------------------------------------------------------------
    */
    protected function callAi(
        string $prompt,
        \Closure $fallback
    ): array {
        $apiKey = config('services.anthropic.key');

        if (! $apiKey) {
            return [
                'text' => $fallback(),
                'is_fallback' => true,
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])
                ->timeout(60)
                ->post(
                    'https://api.anthropic.com/v1/messages',
                    [
                        'model' => config(
                            'services.anthropic.model',
                            'claude-3-5-haiku-20241022'
                        ),

                        /*
                        |--------------------------------------------------------------------------
                        | MAX TOKENS
                        |--------------------------------------------------------------------------
                        | Dibuat besar agar AI dapat memberikan jawaban
                        | yang panjang, detail, dan kompleks.
                        |--------------------------------------------------------------------------
                        */
                        'max_tokens' => 4000,

                        'temperature' => 0.7,

                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $prompt,
                            ],
                        ],
                    ]
                );

            if ($response->successful()) {
                $text = collect(
                    $response->json('content')
                )
                    ->pluck('text')
                    ->filter()
                    ->implode("\n");

                if (! empty(trim($text))) {
                    return [
                        'text' => trim($text),
                        'is_fallback' => false,
                    ];
                }
            }

            report(
                new \RuntimeException(
                    'Anthropic API Error: ' . $response->body()
                )
            );
        } catch (Throwable $e) {
            report($e);
        }

        return [
            'text' => $fallback(),
            'is_fallback' => true,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | FALLBACK CAPTION
    |--------------------------------------------------------------------------
    */
    protected function fallbackCaption(
        string $productName,
        ?string $targetCustomer
    ): string {
        $audience = $targetCustomer ?: 'pelanggan';

        return <<<TEXT
HOOK
Kenalan dengan {$productName}, pilihan produk lokal untuk {$audience}.

CAPTION
{$productName} hadir sebagai salah satu produk UMKM lokal yang dibuat untuk memberikan pilihan yang praktis dan menarik bagi pelanggan.

KEUNGGULAN
• Produk dari UMKM lokal.
• Mendukung perkembangan usaha masyarakat.
• Cocok untuk pelanggan yang ingin memilih produk lokal.

CALL TO ACTION
Yuk kenali produknya lebih lanjut dan dukung UMKM lokal melalui LOKALIN.

HASHTAG
#LOKALIN #UMKM #UMKMLokal #ProdukLokal #DukungUMKM
TEXT;
    }


    /*
    |--------------------------------------------------------------------------
    | FALLBACK CONTENT IDEAS
    |--------------------------------------------------------------------------
    */
    protected function fallbackContentIdeas(
        string $businessType,
        string $product
    ): string {
        $ideas = [
            [
                'judul' => 'Behind the Scenes',
                'tujuan' => 'Membangun kepercayaan',
                'konsep' => "Tampilkan proses pembuatan {$product}.",
                'hook' => "Pernah penasaran bagaimana {$product} dibuat?",
                'format' => 'Video pendek',
                'cta' => 'Follow untuk melihat proses lainnya.',
            ],
            [
                'judul' => 'Kenalan dengan Produk',
                'tujuan' => 'Meningkatkan awareness',
                'konsep' => "Perkenalkan {$product} kepada calon pelanggan.",
                'hook' => "Sudah kenal dengan {$product}?",
                'format' => 'Foto carousel',
                'cta' => 'Cek katalog produk.',
            ],
            [
                'judul' => 'Testimoni Pelanggan',
                'tujuan' => 'Meningkatkan kepercayaan',
                'konsep' => 'Tampilkan pengalaman pelanggan.',
                'hook' => 'Apa kata pelanggan kami?',
                'format' => 'Foto / video',
                'cta' => 'Coba sendiri produknya.',
            ],
            [
                'judul' => 'Tips Edukasi',
                'tujuan' => 'Meningkatkan engagement',
                'konsep' => "Berikan tips yang berkaitan dengan {$product}.",
                'hook' => 'Tahukah kamu tips sederhana ini?',
                'format' => 'Carousel',
                'cta' => 'Simpan postingan ini.',
            ],
            [
                'judul' => 'Promo Terbatas',
                'tujuan' => 'Mendorong pembelian',
                'konsep' => 'Buat penawaran sederhana dengan batas waktu.',
                'hook' => 'Promo spesial hanya untuk periode tertentu!',
                'format' => 'Story / Post',
                'cta' => 'Pesan sekarang.',
            ],
        ];

        return collect($ideas)
            ->map(function ($idea, $index) {
                return ($index + 1) . ". {$idea['judul']}\n"
                    . "Tujuan: {$idea['tujuan']}\n"
                    . "Konsep: {$idea['konsep']}\n"
                    . "Hook: {$idea['hook']}\n"
                    . "Format: {$idea['format']}\n"
                    . "CTA: {$idea['cta']}";
            })
            ->implode("\n\n");
    }


    /*
    |--------------------------------------------------------------------------
    | FALLBACK DESCRIPTION
    |--------------------------------------------------------------------------
    */
    protected function fallbackDescription(
        string $productName,
        ?string $keywords
    ): string {
        $keywordText = $keywords
            ? "Kata kunci yang relevan: {$keywords}."
            : '';

        return <<<TEXT
JUDUL PRODUK
{$productName}

RINGKASAN
{$productName} merupakan produk UMKM lokal yang dapat menjadi pilihan bagi pelanggan yang ingin mendukung usaha lokal.

DESKRIPSI
{$productName} dibuat dan ditawarkan oleh pelaku UMKM lokal dengan perhatian terhadap kualitas produk dan kebutuhan pelanggan.

{$keywordText}

KEUNGGULAN
• Produk dari UMKM lokal.
• Mendukung perkembangan ekonomi lokal.
• Dapat menjadi pilihan untuk kebutuhan pelanggan sehari-hari.

COCOK UNTUK
Pelanggan yang membutuhkan produk lokal dan ingin mendukung pelaku UMKM di sekitarnya.

CALL TO ACTION
Tertarik mencoba? Lihat detail produk dan lakukan pemesanan melalui LOKALIN.
TEXT;
    }


    /*
    |--------------------------------------------------------------------------
    | FALLBACK PROMOTION STRATEGY
    |--------------------------------------------------------------------------
    */
    protected function fallbackPromotionStrategy(
        string $businessType
    ): string {
        $ideas = [
            "Aktifkan Digital Store LOKALIN dan sebarkan QR Code di lokasi usaha {$businessType}.",
            'Posting produk secara rutin dengan foto dan video yang menarik.',
            'Gunakan promo bundling untuk meningkatkan nilai transaksi.',
            'Ajak pelanggan memberikan review setelah melakukan pembelian.',
            'Gunakan WhatsApp Business untuk membangun hubungan dengan pelanggan.',
            'Buat konten edukasi yang berhubungan dengan produk.',
            'Gunakan storytelling untuk memperkenalkan perjalanan usaha.',
            'Evaluasi produk dan konten berdasarkan respon pelanggan.',
        ];

        return collect($ideas)
            ->map(
                fn ($idea, $index) => ($index + 1) . ". {$idea}"
            )
            ->implode("\n");
    }
}