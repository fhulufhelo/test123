<?php

namespace App\Jobs;

use App\Mail\EmployeeNotification;
use App\Repositories\Employees;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationToEmployee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $email)
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Employees $employees)
    {

        $people = $employees
            ->haveBornToday()
            ->stillEmployed()
            ->hasAlreadyStartedWorking()
            ->hasNotYetReceivedBirthDayWishes()
            ->birthWishBlackListed()
            ->get();

        if ($people->isEmpty()) {
            return;
        }

        $names = $people
            ->map(fn($item) => $item->fullName())
            ->implode(', ');

        $message = "Happy Birthday " .$names;

        Mail::to($this->email)
            ->send(new EmployeeNotification('Happy Birthday!','Happy Birthday',$message));

    }
}
