<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class AddCustomerModal extends Component
{
    public $name;
    public $email;
    public $phone_number;

    public function render()
    {
        return view('livewire.customer.add-customer-modal');
    }

    public function submit(){
        $customer = new Customer();
        $customer->name = $this->name;
        $customer->email = $this->email;
        $customer->phone_number = $this->phone_number;
        $customer->save();
    }
}
