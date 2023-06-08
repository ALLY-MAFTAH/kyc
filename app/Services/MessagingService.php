<?php

namespace App\Services;

use App\Models\Sms;
use App\Services\SchoolService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MessagingService
{

    public function sendMessage($receiver, $body)
    {
        $from = 'NEXTSMS';
        $text = $body;
        $to = substr_replace($receiver, "255", 0, 1);

        try {
            $messageResponse = Http::withToken(config('services.nextsms.key'), 'Basic')
                ->asJson()
                ->acceptJson()
                ->post(
                    'https://messaging-service.co.tz/api/sms/v1/text/single',
                    compact('from', 'to', 'text')
                );
            $response = $messageResponse->successful() ? 'Sent' : 'Failed';
            return [
                'status' =>  $response,
                'mobile' =>  '+'.$to,
                'msg' =>  $text,
            ];
        } catch (\Throwable $th) {
            return [
                'status' =>   $th->getMessage(),
            ];
        }
    }
}
