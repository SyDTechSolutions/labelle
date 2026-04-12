<?php

namespace Database\Seeders;

use App\Currency;
use App\Role;
use App\Setting;
use App\Tax;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'users',
        'roles',
        'role_user',
        'customers',
        'providers',
        'products',
        'invoices',
        'invoice_lines',
        'taxes',
        'product_tax',
        'invoice_line_taxes',
        'payments',
        'proformas',
        'proforma_lines',
        'proforma_line_taxes',
        'referencias',
        'settings',
        'currencies'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        Role::create([
            'name' => 'admin',
        ]);
        
        // Vendedor role
        Role::create([
            'name' => 'vendedor',
        ]);

        $admin = User::create([
            'name' => "Soporte MyG",
            'email' => 'soporte@mygenlinea.com',
            'password' => bcrypt('SMyMyG2625'),
            'remember_token' => Str::random(10),
            'status' => 1,
        ])->first();

        DB::table('role_user')->insert(
            ['role_id' => 1, 'user_id' => $admin->id]
        );
        
        Tax::create([
            'name' => 'Impuesto Sobre Ventas',
            'tarifa' => 13
        ]);

        Setting::create([
            'company' => "Nombre de la empresa",
            'ide' => "88888888",
            'phone' => "88888888", // secret
            'address' => "Direcicon de la empresa",
        ]);

        Currency::create([
            'code'=>"USD",
            'name'=> "dollar",
            'symbol'=> "$",
            'exchange'=> 500
        ]);
    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $tablename) {
            DB::table($tablename)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
