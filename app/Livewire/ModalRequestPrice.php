<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class ModalRequestPrice extends Component
{
    public $product;

    #[Validate('required', message: 'Укажите ваше имя.', translate: false)]
    public $name;

    #[Validate('required', message: 'Укажите ваш номер телефона.', translate: false)]
    #[Validate('phone:RU', message: 'Укажите валидный номер телефона.', translate: false)]
    public $phone;

    public $comment;

    #[Validate('nullable')]
    #[Validate('numeric', message: 'Укажите число.', translate: false)]
    #[Validate('min:0', message: 'Укажите положительное число.', translate: false)]
    public $quantity;

    #[Validate('accepted', message: 'Примите пользовательское соглашение.', translate: false)]
    public $privacy;

    public function render()
    {
        return view('livewire.modal-request-price');
    }

    public function sendEmail()
    {
        $this->validate();
    }
}
