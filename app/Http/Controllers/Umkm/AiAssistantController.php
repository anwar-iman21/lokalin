<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Umkm\AiCaptionRequest;
use App\Models\AiGeneration;
use App\Services\AiAssistantService;

class AiAssistantController extends Controller
{
    public function index()
    {
        $umkm = auth()->user()->umkmProfile;
        $history = $umkm->aiGenerations()->latest()->take(10)->get();

        return view('umkm.ai-assistant', compact('history'));
    }

    public function generate(AiCaptionRequest $request, AiAssistantService $ai)
    {
        $umkm = auth()->user()->umkmProfile;
        $data = $request->validated();

        $result = match ($data['type']) {
            'caption' => $ai->generateCaption($data['product_name'], $data['description'] ?? null, $data['target_customer'] ?? null),
            'content_idea' => $ai->generateContentIdeas($data['business_type'], $data['product_name'] ?? $umkm->name),
            'description' => $ai->generateDescription($data['product_name'], $data['keywords'] ?? null),
            'promotion_strategy' => $ai->generatePromotionStrategy($data['business_type']),
        };

        $generation = AiGeneration::create([
            'umkm_id' => $umkm->id,
            'type' => $data['type'],
            'input' => $data,
            'output' => $result['text'],
            'is_fallback' => $result['is_fallback'] ?? true,
        ]);

        return back()->with('ai_result', $generation);
    }
}
