<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\CustomerPayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\PhonpeService;
use Carbon\Carbon;

class PhonePeStatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phonepe:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $phonePeService;
    public function __construct(PhonpeService $phonePeService)
    {
        parent::__construct();
        $this->phonePeService = $phonePeService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $payments = CustomerPayment::where('phonepe_status', 'PENDING')
            ->where('created_at', '>=', now()->subMinutes(15))
            ->limit(5)
            ->get();

        foreach ($payments as $payment) {

            try {
                $response = $this->phonePeService->checkStatus($payment->order_id);

                // log::info($response);

                $data = is_array($response) ? $response : json_decode($response, true);

                if (!is_array($data)) {
                    Log::error('Invalid PhonePe response', [
                        'order' => $payment->order_id,
                        'response' => $response
                    ]);
                    continue;
                }

                $state = data_get($data, 'state');

                if (!$state) {
                    Log::warning('PhonePe state missing', [
                        'order' => $payment->pp_orderId,
                        'data' => $data
                    ]);
                    continue;
                }

                // finalize only once
                if (in_array($state, ['COMPLETED', 'FAILED'])) {
                    $this->finalizePayment($payment, $state, $data);
                    continue;
                }

                // still pending → increment attempt
                $payment->update([
                    'last_polled_at' => now(),
                    'poll_attempt'   => $payment->poll_attempt + 1
                ]);
            } catch (\Exception $e) {
                Log::error('PhonePe Polling Error', [
                    'order' => $payment->pp_orderId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return Command::SUCCESS;
    }

    private function finalizePayment($payment, string $state, array $response)
    {
        if ($payment->phonepe_status !== 'PENDING') {
            return;
        }

        $payment->update([
            'phonepe_status' => $state,
            'payment_done'   => $state === 'COMPLETED' ? 1 : 0,
            // 'last_polled_at' => now()
        ]);

        if ($state === 'COMPLETED') {
            Booking::where('id', $payment->booking_id)
                ->where('status', '!=', 1)
                ->update(['status' => 1]);
        }

        $this->phonePeService->paymentStatus(
            collect([
                'transaction_id' => $payment->transaction_id,
                'pp_orderId'     => $payment->pp_orderId,
                'state'          => $state,
                'raw_response'   => $response
            ]),
            1
        );

        Log::info('PhonePe payment finalized', [
            'order' => $payment->pp_orderId,
            'state' => $state
        ]);
    }
}
