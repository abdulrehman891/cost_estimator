<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Auth;
class AddCustomerModal extends Component
{
    public $name;
    public $email;
    public $phone_number;
    public $edit_mode = false;
    public $customer_id;
    public $company_name;
    public $company_address;
    public $company_phone;
    public $company_email;

    //delete_customer
    protected $listeners = [
        'delete_customer' => 'deleteCustomer',
        'update_customer' => 'updateCustomer',
    ];
    public function render()
    {
        return view('livewire.customer.add-customer-modal');
    }

    public function submit(){
        $customer = Customer::find($this->customer_id);
        if($customer)
        {
            $customer->name = $this->name;
            $customer->email = $this->email;
            $customer->phone_number = $this->phone_number;
            $customer->company_name = $this->company_name;
            $customer->company_address = $this->company_address;
            $customer->company_phone = $this->company_phone;
            $customer->company_email = $this->company_email;
            $customer->created_by =  Auth::user()->id;
            $customer->save();

        }else{
            $customer = new Customer();
            $customer->name = $this->name;
            $customer->email = $this->email;
            $customer->phone_number = $this->phone_number;
            $customer->company_name = $this->company_name;
            $customer->company_address = $this->company_address;
            $customer->company_phone = $this->company_phone;
            $customer->company_email = $this->company_email;
            $customer->created_by =  Auth::user()->id;
            $customer->save();
        }
        if ($this->edit_mode) {
            $this->emit('success', __('Customer updated'));
        } else {
            // Emit a success event with a message
            $this->emit('success', __('New Customer created'));
        }
    }

    public function updateCustomer($id){
        $this->edit_mode = true;
        $customer = Customer::find($id);
        $this->name = $customer->name;
        $this->customer_id = $id;
        $this->email = $customer->email;
        $this->phone_number = $customer->phone_number;
    }
    public function deleteCustomer($id)
    {
        Customer::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Customer successfully deleted');
    }
}
