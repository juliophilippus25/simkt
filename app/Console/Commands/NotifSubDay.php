<?php

namespace App\Console\Commands;

use App\Mail\SubDays;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifSubDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notif-sub-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pemberitahuan 10 hari sebelum masa sewa habis.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userRoom = UserRoom::where('rent_period', '<=', Carbon::now()->subDays(10))->get();

        foreach ($userRoom as $room) {
            Mail::to($room->user->email)->send(new SubDays($userRoom));
        }
    }
}
