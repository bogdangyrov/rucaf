<?php

namespace App\Livewire;

use Livewire\Component;
use App\Mail\RequestCall;
use App\Mail\RequestPrice;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;

class ModalRequestCall extends Component
{
    #[Validate('required', message: 'Укажите ваше имя.', translate: false)]
    public $name;

    #[Validate('required', message: 'Укажите ваш номер телефона.', translate: false)]
    #[Validate('phone:RU', message: 'Укажите валидный номер телефона.', translate: false)]
    public $phone;

    public $comment;

    #[Validate('accepted', message: 'Примите пользовательское соглашение.', translate: false)]
    public $privacy;

    public $emailSended = false;

    public function render()
    {
        return view('livewire.modal-request-call');
    }

    public function sendEmail()
    {
        $this->validate();

        $result = Mail::to(env('MAIL_TO_ADDRESS'))->send(new RequestCall(
            $this->name,
            $this->phone,
            $this->comment
        ));

        if ($result) {
            $this->emailSended = true;
        }
    }
}
