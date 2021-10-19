<?php

namespace App\Http\Livewire;

use App\Withdraw;
use App\EmailTemplate;
use App\Mail\PaymentRequestCreated;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Withdrawals extends Component
{
    use WithPagination;

    public $tab = 'Pending';

    public function mount()
    {
        if (auth()->guest())
            abort(403);
    }

    public function tab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function cancelPending($id)
    {
        $w = auth()->user()->withdrawals()->where('withdraws.id', $id)->firstOrFail();

        if ($w->status != 'Pending')
            abort(403);

        $w->status = 'Canceled';
        $w->save();

        $this->emit('swal', [
            'icon' => 'success',
            'title' => __('general.successfullyCanceledWithdrawal')
        ]);
    }

    public $requestAmount;

    public function sendRequest()
    {
        if (auth()->user()->profile->payout_gateway == 'None' or empty(auth()->user()->profile->payout_details)) {

            $this->emit('swal', [
                'icon' => 'error',
                'message' => __('dashboard.msgSetBankDetails')
            ]);

            return;
        }


        // $amount = auth()->user()->balance;
        $amount = $this->requestAmount;

        $pendingWithdrawals = auth()->user()->withdrawals()
            ->where('status', 'Pending')
            ->exists();

        if ($pendingWithdrawals) {

            $this->emit('swal', [
                'icon' => 'error',
                'message' => __('general.waitUntilPending')
            ]);

            return;
        }

        if ($amount < opt('withdraw_min', 20)) {

            $minAmount = opt('payment-settings.currency_symbol') . opt('withdraw_min', 20);

            $this->emit('swal', [
                'icon' => 'error',
                'message' => __(
                    'general.withdrawMin',
                    [
                        'minWithdrawAmount' => $minAmount,
                    ]
                )
            ]);
        } else {

            // create withdrawal
            $w = new Withdraw();
            $w->user_id = auth()->user()->id;
            $w->amount = $amount;
            $w->save();

            // notify admin

            $getEmailTemplate = EmailTemplate::findorFail(4);
            $emailSubject = $getEmailTemplate->emailSubject;
            $emailBody = $getEmailTemplate->emailBody;
            $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
            $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
            $emailBody = str_replace('{withdraw_amount}', opt('payment-settings.currency_symbol') .  $w->amount, $emailBody);
            $emailBody = str_replace('{withdraw_username}', $w->user->name, $emailBody);
            $emailBody = str_replace('{withdraw_user_profile}', route('profile.show', ['username' => $w->user->profile->username]), $emailBody);
            $emailBody = str_replace('{withdraw_user_handle}', $w->user->profile->handle, $emailBody);
            $emailBody = str_replace('{payment_requests_url}', route('admin.payment-requests'), $emailBody);

            $adminEmail = opt('admin_email', 'support@yoursite.com');
            Mail::to($adminEmail)->send(new PaymentRequestCreated($w, $emailSubject, $emailBody));

            // emit message
            $this->emit('swal', [
                'icon' => 'success',
                'message' => __('general.withdrawSent')
            ]);
        }
    }

    public function render()
    {
        $tab = $this->tab;

        $user = auth()->user();

        $withdrawals = $user->withdrawals()
            ->where('status', $tab)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.withdrawals', compact('withdrawals'));
    }
}
