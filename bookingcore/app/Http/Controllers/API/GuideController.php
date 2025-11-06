<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use Illuminate\Http\Request;


class GuideController extends Controller
{
    public function index(Request $request)
    {
        $min = (int) $request->integer('min_experience', 0);
        $q = Guide::query()->where('is_active', true);
        if ($min > 0) {
            $q->where('experience_years', '>=', $min);
        }
        $guides = $q->orderByDesc('experience_years')->orderBy('name')->paginate(20);
        return GuideResource::collection($guides)->additional([
            'meta' => [
                'min_experience' => $min,
            ],
        ]);
    }
}
