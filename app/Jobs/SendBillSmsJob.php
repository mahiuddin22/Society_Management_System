<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SmsGateway;

class SendBillSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $name;
    protected $total;
    protected $month;
    protected $holding;
    protected $flat;
    protected $message;

    public function __construct($phone, $name, $total, $month, $holding, $flat, $message)
    {
        $this->phone = $phone;
        $this->name = $name;
        $this->total = $total;
        $this->month = $month;
        $this->holding = $holding;
        $this->flat = $flat;
        $this->message = $message;
    }

    public function handle(): void
    {
        app(SmsGateway::class)->send($this->phone, $this->message);
    }
}
