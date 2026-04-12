<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Purchase;

class UniquePurchase implements Rule
{
    protected $providerId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($providerId, $purchaseId = null)
    {
        $this->providerId = $providerId;
        $this->purchaseId = $purchaseId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       
        if($this->purchaseId){
            
            return !Purchase::where('id','<>', $this->purchaseId)->where('provider_id', $this->providerId)->where('factura_proveedor', $value)->exists();
        }

        return !Purchase::where('provider_id', $this->providerId)->where('factura_proveedor', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ya se encuentra una factura con este numero y este proveedor.';
    }
}
