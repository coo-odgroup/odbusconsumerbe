<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Throwable;

class StoreRouteSearchDaily extends Command
{
    protected $signature = 'route-search:store-daily';

    protected $description = 'Store Redis bus searches in MySQL';

    public function handle()
    {
        $redisKey = 'route_search_daily';
        $processingKey = 'route_search_daily:processing';

        try {
            // Move records atomically into a processing list.
            // New searches can continue entering the original list.
            while (Redis::rpoplpush($redisKey, $processingKey)) {
                // Continue until the original list is empty.
            }

            $records = Redis::lrange($processingKey, 0, -1);

            if (empty($records)) {
                $this->info('No bus searches to process.');
                return self::SUCCESS;
            }

            // Group identical searches and count occurrences.
            $grouped = [];

            // foreach ($records as $record) {
            //     $data = json_decode($record, true);

            //     if (
            //         !is_array($data) ||
            //         empty($data['search_date']) ||
            //         !isset($data['source']) ||
            //         !isset($data['destination']) ||
            //         !isset($data['ip_address'])
            //     ) {
            //         throw new \RuntimeException(
            //             'Invalid bus search record: ' . $record
            //         );
            //     }

            //     $groupKey = json_encode([
            //         $data['search_date'],
            //         $data['source'],
            //         $data['destination'],
            //         $data['ip_address'],
            //     ]);

            //     $searchTime = $data['created_at'] ?? now()->toDateTimeString();

            //     if (!isset($grouped[$groupKey])) {
            //         $grouped[$groupKey] = [
            //             'search_date'  => $data['search_date'],
            //             'source'       => $data['source'],
            //             'destination'  => $data['destination'],
            //             'ip_address'   => $data['ip_address'],
            //             'created_at'   => $searchTime,
            //             'updated_at'   => $searchTime,
            //             'search_count' => 0,
            //         ];
            //     }

            //     // Preserve the earliest and latest search timestamps
            //     if ($searchTime < $grouped[$groupKey]['created_at']) {
            //         $grouped[$groupKey]['created_at'] = $searchTime;
            //     }

            //     if ($searchTime > $grouped[$groupKey]['updated_at']) {
            //         $grouped[$groupKey]['updated_at'] = $searchTime;
            //     }

            //     $grouped[$groupKey]['search_count']++;
            // }

            // DB::transaction(function () use ($grouped) {
            //     foreach ($grouped as $data) {
            //         $key = [
            //             'search_date' => $data['search_date'],
            //             'source'      => $data['source'],
            //             'destination' => $data['destination'],
            //             'ip_address'  => $data['ip_address'],
            //         ];

            //         $existing = DB::table('route_search_daily')
            //             ->where($key)
            //             ->first();

            //         if ($existing) {
            //             DB::table('route_search_daily')
            //                 ->where($key)
            //                 ->update([
            //                     'search_count' => DB::raw(
            //                         'search_count + ' . (int) $data['search_count']
            //                     ),
            //                     'updated_at' => $data['updated_at'],
            //                 ]);
            //         } else {
            //             DB::table('route_search_daily')->insert(
            //                 array_merge($key, [
            //                     'search_count' => $data['search_count'],
            //                     'created_at'   => $data['created_at'],
            //                     'updated_at'   => $data['updated_at'],
            //                 ])
            //             );
            //         }
            //     }
            // });


            $insertData = [];

            foreach ($records as $record) {
                $data = json_decode($record, true);

                if (
                    !is_array($data) ||
                    empty($data['search_date']) ||
                    !isset($data['source']) ||
                    !isset($data['destination']) ||
                    !isset($data['ip_address'])
                ) {
                    throw new \RuntimeException(
                        'Invalid bus search record: ' . $record
                    );
                }

                $searchTime = $data['created_at'] ?? now()->toDateTimeString();

                $insertData[] = [
                    'search_date' => $data['search_date'],
                    'source'      => $data['source'],
                    'destination' => $data['destination'],
                    'ip_address'  => $data['ip_address'],
                    'created_at'  => $searchTime,
                    'updated_at'  => $searchTime,
                ];
            }

            // Batch insert all records without grouping or duplicate checks.
            DB::transaction(function () use ($insertData) {
                foreach (array_chunk($insertData, 500) as $batch) {
                    DB::table('backup_route_search_daily')->insert($batch);
                }
            });


            // Delete the processing list only after the DB commit.
            Redis::del($processingKey);

            $this->info(
                count($records) . ' bus searches saved successfully.'
            );

            return self::SUCCESS;
        } catch (Throwable $e) {
            // Keep the processing list so the records can be retried.
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
