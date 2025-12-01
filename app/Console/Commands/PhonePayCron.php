<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\PhonePayToken;
use Exception;

class PhonePayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:oauth-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update PhonePe payment status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $url = Config('constants.PHONPE_API_URL');
            $response = Http::withoutVerifying()->asForm()->post(
                $url.'v1/oauth/token',
                [
                    "client_id" => Config('constants.CLIENT_ID'),
                    "client_secret" => Config('constants.CLIENT_SECRET'),
                    "client_version" => Config('constants.CLIENT_VERSION'),
                    "grant_type" => Config('constants.GRANT_TYPE'),
                ]
            );

            // Check for API error
            if (!$response->successful()) {
                Log::error('PhonePe Token API Failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception("PhonePe API request failed.");
            }

            // Check if record exists
            $record = PhonePayToken::first();

            $data = [
                'access_token' => $response['access_token'],
                'encrypted_access_token' => $response['encrypted_access_token'],
                'expires_in' => $response['expires_in'],
                'issued_at' => date('Y-m-d H:i:s', $response['issued_at']),
                'expires_at' => date('Y-m-d H:i:s', $response['expires_at']),
                'session_expires_at' => date('Y-m-d H:i:s', $response['session_expires_at']),
                'token_type' => $response['token_type']
            ];

            if (!$record) {
                // insert first time
                $data['created_at'] = now();
                PhonePayToken::create($data);
                Log::info('PhonePe Token inserted first time.');
            } else {
                // update same record
                $data['updated_at'] = now();
                $record->update($data);
                Log::info('PhonePe Token updated.');
            }

        } catch (\Throwable $e) {
            Log::error('PhonePe Token Error: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
