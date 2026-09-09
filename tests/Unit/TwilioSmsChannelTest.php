<?php 
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Messaging\OutboundMessage;
use App\Messaging\TwilioSmsChannel;
use Illuminate\Support\Facades\Http;

class TwilioSmsChannelTest extends TestCase
{
    public function test_sms_channel_sends_request(): void
    {
        Http::fake([
            'api.twilio.com/*' => Http::response([], 201),
        ]);

        config([
            'services.twilio.sid' => 'test_sid',
            'services.twilio.token' => 'test_token',
            'services.twilio.from' => '+10000000000',
        ]);

        $employee = new Employee([
            'phone' => '+3456782347',
        ]);

        $channel = app(TwilioSmsChannel::class);

        $result = $channel->send(
            $employee,
            new OutboundMessage('Test SMS')
        );

        $this->assertTrue($result->success);
    }
}