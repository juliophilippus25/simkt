<?php

namespace App\Console\Commands;

use App\Models\ApplyResidency;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectApplicactionWithoutPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reject-applicaction-without-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menolak pengajuan yang belum dibayar setelah 3 hari.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $applications = ApplyResidency::where('status', 'pending-payment')
        ->where('updated_at', '<', Carbon::now()->subDays(3))
        ->get();

        foreach ($applications as $application) {
            $payment = Payment::where('user_id', $application->user_id)
                ->where('created_at', '>=', $application->created_at)
                ->where('created_at', '<=', Carbon::parse($application->created_at)->addDays(3))
                ->whereNotNull('proof')
                ->first();

            if (!$payment) {
                $application->status = 'rejected';
                $application->reason = 'Mohon maaf, pengajuan Anda di tolak karena belum melakukan pembayaran.';
                $application->save();
            }
        }
    }
}
