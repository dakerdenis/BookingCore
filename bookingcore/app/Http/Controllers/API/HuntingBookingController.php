<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHuntingBookingRequest;
use App\Http\Resources\HuntingBookingResource;
use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


class HuntingBookingController extends Controller
{
    public function store(StoreHuntingBookingRequest $request): JsonResponse
    {
        $payload = $request->validated();


        $exists = HuntingBooking::query()
            ->where('guide_id', $payload['guide_id'])
            ->whereDate('date', $payload['date'])
            ->exists();
        if ($exists) {
            return response()->json([
                'message' => 'Guide is not available on selected date.'
            ], Response::HTTP_CONFLICT);
        }


        $guide = Guide::query()->whereKey($payload['guide_id'])->first();
        if (!$guide || !$guide->is_active) {
            return response()->json([
                'message' => 'Selected guide is not available.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        if ((int) $payload['participants_count'] > 10) {
            return response()->json([
                'message' => 'participants_count must be less than or equal to 10.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $booking = DB::transaction(function () use ($payload) {
            return HuntingBooking::create($payload);
        });


        return response()->json(new HuntingBookingResource($booking->load('guide')), Response::HTTP_CREATED);
    }
}
