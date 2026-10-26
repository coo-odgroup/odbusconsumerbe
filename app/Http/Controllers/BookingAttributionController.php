<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingAttributionController extends Controller
{
    public function saveAttribution(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',

            'attribution' => 'required|array',

            'attribution.first_touch' => 'nullable|array',
            'attribution.first_touch.utm_source' => 'nullable|string|max:255',
            'attribution.first_touch.utm_medium' => 'nullable|string|max:255',
            'attribution.first_touch.utm_campaign' => 'nullable|string|max:255',
            'attribution.first_touch.utm_content' => 'nullable|string|max:255',
            'attribution.first_touch.utm_term' => 'nullable|string|max:255',

            'attribution.last_touch' => 'nullable|array',
            'attribution.last_touch.utm_source' => 'nullable|string|max:255',
            'attribution.last_touch.utm_medium' => 'nullable|string|max:255',
            'attribution.last_touch.utm_campaign' => 'nullable|string|max:255',
            'attribution.last_touch.utm_content' => 'nullable|string|max:255',
            'attribution.last_touch.utm_term' => 'nullable|string|max:255',

            'attribution.click_ids' => 'nullable|array',
            'attribution.click_ids.fbclid' => 'nullable|string|max:2048',
            'attribution.click_ids.gclid' => 'nullable|string|max:2048',
            'attribution.click_ids.gbraid' => 'nullable|string|max:2048',
            'attribution.click_ids.wbraid' => 'nullable|string|max:2048',
            'attribution.click_ids.gad_source' => 'nullable|string|max:255',
            'attribution.click_ids.gad_campaignid' => 'nullable|string|max:255',

            'attribution.fbc' => 'nullable|string|max:2048',
            'attribution.fbp' => 'nullable|string|max:255',
            'attribution.landing_url' => 'nullable|string|max:2048',
            'attribution.referrer' => 'nullable|string|max:2048',
            'attribution.captured_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid attribution data',
                'errors' => $validator->errors()
            ], 422);
        }

        $attribution = $request->input('attribution');

        $firstTouch = $attribution['first_touch'] ?? [];
        $lastTouch = $attribution['last_touch'] ?? [];
        $clickIds = $attribution['click_ids'] ?? [];

        $capturedAt = null;

        if (!empty($attribution['captured_at'])) {
            $capturedAt = Carbon::parse(
                $attribution['captured_at']
            )->toDateTimeString();
        }

        $data = [
            'first_utm_source' =>
            $firstTouch['utm_source'] ?? null,

            'first_utm_medium' =>
            $firstTouch['utm_medium'] ?? null,

            'first_utm_campaign' =>
            $firstTouch['utm_campaign'] ?? null,

            'first_utm_content' =>
            $firstTouch['utm_content'] ?? null,

            'last_utm_source' =>
            $lastTouch['utm_source'] ?? null,

            'last_utm_medium' =>
            $lastTouch['utm_medium'] ?? null,

            'last_utm_campaign' =>
            $lastTouch['utm_campaign'] ?? null,

            'last_utm_content' =>
            $lastTouch['utm_content'] ?? null,

            // Prefer the latest touch's term, then first-touch term.
            'utm_term' =>
            $lastTouch['utm_term']
                ?? $firstTouch['utm_term']
                ?? null,

            'fbclid' => $clickIds['fbclid'] ?? null,
            'gclid' => $clickIds['gclid'] ?? null,
            'gbraid' => $clickIds['gbraid'] ?? null,
            'wbraid' => $clickIds['wbraid'] ?? null,

            'fbc' => $attribution['fbc'] ?? null,
            'fbp' => $attribution['fbp'] ?? null,

            'landing_url' => $attribution['landing_url'] ?? null,
            'referrer' => $attribution['referrer'] ?? null,

            'captured_at' => $capturedAt,
        ];

        DB::table('booking_attributions')->updateOrInsert(
            [
                'booking_id' => $request->input('booking_id')
            ],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Booking attribution saved successfully'
        ]);
    }
}
