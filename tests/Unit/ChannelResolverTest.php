<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Messaging\ChannelResolver;
use App\Messaging\SmtpEmailChannel;
use App\Messaging\TwilioSmsChannel;
use App\Messaging\LogChannel;

class ChannelResolverTest extends TestCase
{
    public function test_email_channel_is_selected(): void
    {
        $employee = new Employee([
            'preferred_channel' => 'email',
        ]);

        $resolver = app(ChannelResolver::class);

        $this->assertInstanceOf(
            SmtpEmailChannel::class,
            $resolver->resolve($employee)
        );
    }

    public function test_sms_channel_is_selected(): void
    {
        $employee = new Employee([
            'preferred_channel' => 'sms',
        ]);

        $resolver = app(ChannelResolver::class);

        $this->assertInstanceOf(
            TwilioSmsChannel::class,
            $resolver->resolve($employee)
        );
    }

    public function test_log_channel_is_selected_by_default(): void
    {
        $employee = new Employee([
            'preferred_channel' => 'other',
        ]);

        $resolver = app(ChannelResolver::class);

        $this->assertInstanceOf(
            LogChannel::class,
            $resolver->resolve($employee)
        );
    }
}