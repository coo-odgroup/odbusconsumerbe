<?php

namespace App\Services;

use App\Models\BusSeatCount;
use App\Models\TicketPrice;
use App\Models\BusLocationSequence;
use Illuminate\Support\Facades\DB;

class InventoryService
{
   
    public function holdSeats(int $busId,string $journeyDate,int $sourceId,int $destinationId,int $seatCount
    ) {
        $segmentIds = $this->getOverlapSegmentIds(
            $busId,
            $sourceId,
            $destinationId
        );

        BusSeatCount::whereIn('ticket_price_id', $segmentIds)
                    ->where('journey_date', $journeyDate)
                    ->update([
                        'hold_seat' => DB::raw("hold_seat + {$seatCount}"),
                        'updated_by' => 'hold'
                    ]);
    }

    public function bookSeats(int $busId,string $journeyDate,int $sourceId,int $destinationId,int $seatCount
    ) {
        $segmentIds = $this->getOverlapSegmentIds(
            $busId,
            $sourceId,
            $destinationId
        );

        BusSeatCount::whereIn('ticket_price_id', $segmentIds)
                    ->where('journey_date', $journeyDate)
                    ->update([
                        'booked_seat' => DB::raw("booked_seat + {$seatCount}"),
                        'updated_by' => 'booking'
                    ]);
    }

    public function cancelSeats(int $busId,string $journeyDate,int $sourceId,int $destinationId,int $seatCount
    ) {
        $segmentIds = $this->getOverlapSegmentIds(
            $busId,
            $sourceId,
            $destinationId
        );

       BusSeatCount::whereIn('ticket_price_id', $segmentIds)
                    ->where('journey_date', $journeyDate)
                    ->update([
                        'booked_seat' => DB::raw("GREATEST(booked_seat - {$seatCount},0)"),
                        'updated_by' => 'cancel'
                    ]);
    }

  
    public function releaseHoldSeats(int $busId, string $journeyDate, int $sourceId, int $destinationId,int $seatCount ) {

        $seatCount = (int) $seatCount;

        $segmentIds = $this->getOverlapSegmentIds(
            $busId,
            $sourceId,
            $destinationId
        );

        if (empty($segmentIds)) {
            return true;
        }

       BusSeatCount::whereIn('ticket_price_id', $segmentIds)
                    ->where('journey_date', $journeyDate)
                    ->update([
                        'hold_seat' => DB::raw(
                            "GREATEST(hold_seat - {$seatCount},0)"
                        ),
                        'updated_by' => 'hold_release'
                    ]);

        return true;
    }

    public function refreshAvailableSeats(
        array $segmentIds,
        string $journeyDate
    )
    {
        BusSeatCount::whereIn('ticket_price_id', $segmentIds)
            ->where('journey_date', $journeyDate)
            ->update([
                'available_seat' => DB::raw("
                    GREATEST(
                        total_seat
                        - booked_seat
                        - blocked_seat
                        - hold_seat,
                        0
                    )
                ")
            ]);
    }
   
    private function getOverlapSegmentIds(int $busId,int $sourceId,int $destinationId
    ): array {

        $reqStart = BusLocationSequence::where('bus_id', $busId)
            ->where('location_id', $sourceId)
            ->value('sequence');

        $reqEnd = BusLocationSequence::where('bus_id', $busId)
            ->where('location_id', $destinationId)
            ->value('sequence');

        return TicketPrice::select('ticket_price.id')
            ->join(
                'bus_location_sequence as seg_start',
                function ($join) {
                    $join->on(
                        'seg_start.location_id',
                        '=',
                        'ticket_price.source_id'
                    )->on(
                        'seg_start.bus_id',
                        '=',
                        'ticket_price.bus_id'
                    );
                }
            )
            ->join(
                'bus_location_sequence as seg_end',
                function ($join) {
                    $join->on(
                        'seg_end.location_id',
                        '=',
                        'ticket_price.destination_id'
                    )->on(
                        'seg_end.bus_id',
                        '=',
                        'ticket_price.bus_id'
                    );
                }
            )
            ->where('ticket_price.bus_id', $busId)
            ->where('ticket_price.status', 1)

            ->whereRaw(
                'seg_start.sequence < ?',
                [$reqEnd]
            )

            ->whereRaw(
                '? < seg_end.sequence',
                [$reqStart]
            )

            ->pluck('ticket_price.id')
            ->toArray();
    }
}