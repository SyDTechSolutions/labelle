<?php

namespace Tests\Feature;

use App\Customer;
use App\Invoice;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class CustomerReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_generate_a_invoices_by_customer_report()
    {
        $this->withoutExceptionHandling();
        $this->be(factory(User::class)->create());
        $customer = factory(Customer::class)->create();
        $customer2 = factory(Customer::class)->create();
    
        factory(Invoice::class, 2)->create(['customer_id' => $customer->id, 'TotalWithNota' => 300, 'TotalComprobante' => 300]);
        factory(Invoice::class, 10)->create(['customer_id' => $customer2->id, 'TotalWithNota' => 100, 'TotalComprobante' => 100,  'created_at' => Carbon::now()->yesterday(), 'updated_at' => Carbon::now()->yesterday()]);

      
        $data = [
            'name' => $customer->name,
            'invoices_count' => 2,
            'invoices_total' => 600,
        ];
       
        $this->get('/reports/customers/invoices?start=2020-08-11&end=2020-08-14')
              ->assertStatus(200)
             ->assertSee($data['name'])
             ->assertSee($data['invoices_count'])
             ->assertSee($data['invoices_total'])
             ->assertSee($customer2->name)
             //->assertDontSee(10)
             ->assertDontSee(1000);

       
    }
}
