<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\AliasLoader;
use App\User;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      if ($this->app->environment('production')) {
          URL::forceScheme('https');
      }

      if (method_exists(Paginator::class, 'useBootstrap')) {
          Paginator::useBootstrap();
      }
      // Schema::defaultStringLength(191); // No longer needed in Laravel 11

        // Email array validator
        if ($this->app->bound('validator')) {
            Validator::extend('email_array', function ($attribute, $value, $parameters, $validator) {
                $value = str_replace(' ', '', $value);
                $array = explode(',', $value);
                foreach ($array as $email) //loop over values
                {
                    $email_to_validate['alert_email'][] = $email;
                }
                $rules = array('alert_email.*' => 'email');
                $messages = array(
                    'alert_email.*' => trans('validation.email_array')
                );
                $validator = Validator::make($email_to_validate, $rules, $messages);
                if ($validator->passes()) {
                    return true;
                } else {
                    return false;
                }
            });
        }
    
        // Only run view composers if the application is fully booted
        if (!$this->app->runningInConsole() || $this->app->bound('view')) {
            $this->registerViewComposers();
        }
    }

    /**
     * Register view composers.
     *
     * @return void
     */
    protected function registerViewComposers()
    {
        // $caja = \App\Caja::whereDate('created_at', \Carbon\Carbon::now()->toDateString())->first();
        
        // View::share('caja', $caja);

        view()->composer(['invoices.print', 'invoices.ticket', 'invoices.pdf', 'emails.invoices.send', 'cxc.print', 'proformas.print',
         'proformas.ticket', 'proformas.pdf', 'emails.proformas.send', 'reports.invoices.print', 'reports.invoices.summaryPrint', 'purchases.print', 'purchases.ticket', 
         'purchases.pdf', 'emails.purchases.send', 'reports.products.sold_print', 'cxp.print','cxp.printEstado', 'cierres.print', '
         reports.products.purchased_print', 'reports.sellers.invoices_print', 'reports.customers.invoices_print', 'proformaPurchases.print', 
         'proformaPurchases.ticket', 'proformaPurchases.pdf', 'emails.proformaPurchases.send', 'reports.cxps.print', 'reports.cxcs.print', 
         'reports.expenses.print', 'invoices.partials.form','electronicInvoice.partials.form', 'customers.cxc.print','customers.cxc.printHistorial','reports.facturasProveedor.print'
        ,'electronicInvoice.print','electronicInvoice.ticket','electronicInvoice.pdf','receptors.create'], function ($view) {
            $setting = \App\Setting::with('configFactura')->first();

            $view->with(compact('setting'));
        });

        view()->composer('users.partials.form', function ($view) {
            $roles = \App\Role::all();

            $view->with(compact('roles'));
        });

        view()->composer(['products.partials.form', 'invoices.partials.form','electronicInvoice.partials.form', 'purchases.partials.form', 'proformas.partials.form','productProviders.partials.form', 'proformaPurchases.partials.form'], function ($view) {
            $providers = \App\Provider::all();
            $taxes = \App\Tax::all();
            $measures = [
                'Unid',
                'M',
                'Kg',
                'L',
                'Cm',
                'Sp',
            ];


            $view->with(compact('providers', 'measures', 'taxes'));
        });

        view()->composer('taxes.partials.form', function ($view) {
           
            $codesTaxes = [
                ['code' => '01', 'name' => 'Impuesto al Valor Agregado'],
                ['code' => '02', 'name' => 'Impuesto Selectivo de Consumo'],
                ['code' => '03', 'name' => 'Impuesto Único a los combustibles'],
                ['code' => '04', 'name' => 'Impuesto específico de Bebidas Alcohólicas'],
                ['code' => '05', 'name' => 'Impuesto Específico sobre las bebidas envasadas sin contenido alcohólico y jabones de tocador'],
                ['code' => '06', 'name' => 'Impuesto a los Productos de Tabaco'],
                ['code' => '07', 'name' => 'IVA (cálculo especial)'],
                ['code' => '08', 'name' => 'IVA Régimen de Bienes Usados (Factor)'],
                ['code' => '12', 'name' => 'Impuesto Específico al Cemento'],
                ['code' => '99', 'name' => 'Otros'],
               
            ];
            $codesTarifaIVA = [
                ['code' => '01', 'name' => 'Tarifa 0% (Articulo 32, num, RLIVA)', 'value' => 0 ],
                ['code' => '02', 'name' => 'Tarifa reducida 1%', 'value' => 1 ],
                ['code' => '03', 'name' => 'Tarifa reducida 2%', 'value' => 2 ],
                ['code' => '04', 'name' => 'Tarifa reducida 4%', 'value' => 4 ],
                ['code' => '05', 'name' => 'Transitorio 0%', 'value' => 0 ],
                ['code' => '06', 'name' => 'Transitorio 4%', 'value' => 4 ],
                ['code' => '07', 'name' => 'Transitorio 8%', 'value' => 8 ],
                ['code' => '08', 'name' => 'Tarifa general 13%', 'value' => 13 ],
                ['code' => '09', 'name' => 'Tarifa reducida 0,5%', 'value' => 0.5 ],
                ['code' => '10', 'name' => 'Tarifa Exenta', 'value' => 0 ],
                ['code' => '11', 'name' => 'Tarifa 0% sin derecho a crédito', 'value' => 0 ],
            ];
             
         

            $view->with(compact('codesTaxes', 'codesTarifaIVA'));
        });

        view()->composer(['invoices.partials.form','electronicInvoice.partials.form', 'proformas.partials.form', 'purchases.partials.form', 'proformaPurchases.partials.form'], function ($view) {

            $tipoDocumentos = [
                '01' => 'Factura',
                '02' => 'Nota débito',
                '03' => 'Nota crédito',
                '04' => 'Tiquete electrónico',
                '10' => 'Recibo electrónico de pago'
               /* '05' => 'Nota de despacho',
                '06' => 'Contrato',
                '07' => 'Procedimiento',
                '08' => 'Comprobante emitido en contingencia',
                '99' => 'Otro'*/
            ];
            $tipoDocumentosNotas = [
                '01' => 'Factura',
                '02' => 'Nota débito',
                '03' => 'Nota crédito',
                '04' => 'Tiquete electrónico',
                '05' => 'Nota de despacho',
                '06' => 'Contrato',
                '07' => 'Procedimiento',
                '08' => 'Comprobante emitido en contingencia',
                '09' => 'Devolución mercadería',
                '10' => 'Sustituye factura rechazada por el Ministerio de Hacienda',
                '11' => 'Sustituye factura rechazada por el Receptor del comprobante  
11',
                '12' => 'Sustituye Factura de exportación',
                '13' => '*Facturación mes vencido',
                '99' => 'Otro'
            ];
            $medioPagos = [
                '01' => 'Efectivo',
                '02' => 'Tarjeta',
                '03' => 'Cheque',
                '04' => 'Transferencia – depósito bancario',
                '06' => 'SINPE Móvil'
            ];
            $condicionVentas = [
                '01' => 'Contado',
                '02' => 'Crédito',
                '11' => 'Ventas a crédito'
            ];
            $codigoReferencias = [
                '01' => 'Anula Documento de Referencia',
                '02' => 'Corrige monto',
                '04' => 'Referencia a otro documento',
                '05' => 'Sustituye comprobante provisional por contingencia',
                '06' => 'Devolución de mercancía',
                '07' => 'Sustituye comprobante electrónico',
                '08' => 'Factura Endosada',
                '09' => 'Nota de crédito financiera',
                '10' => 'Nota de débito financiera',
                '11' => 'Proveedor No Domiciliado',
                '99' => 'Otro',

            ];

            $tipoIdentificaciones = [
                '01' => 'Cédula Física',
                '02' => 'Cédula Jurídica',
                '03' => 'DIMEX',
                '04' => 'NITE',
                '00' => 'Extranjero'

            ];

            $tipoDocumentosExo = [
                '01' => 'Compras autorizadas',
                '02' => 'Ventas exentas a diplomáticos',
                '03' => 'Autorizado por Ley especial',
                '04' => 'Exenciones Dirección General de Hacienda',
                '05' => 'Transitorio V',
                '06' => 'Transitorio IX',
                '07' => 'Transitorio XVII',
                '99' => 'Otro'
            ];
            if( auth()->user()->hasRole('admin')){
                $users = User::all();
            }else{
                $users = User::where('id', auth()->user()->id)->get();
            }
           

            $view->with(compact('tipoDocumentos','medioPagos', 'condicionVentas', 'tipoDocumentosNotas', 'codigoReferencias', 'tipoIdentificaciones','tipoDocumentosExo', 'users'));
        });

        view()->composer(['reports.invoices.index','reports.expenses.index','reports.facturasProveedor.index','reports.receptors.index'], function ($view) {
            
            $users = User::all();

            $tipoDocumentos = [
                '01' => 'Factura',
                '02' => 'Nota débito',
                '03' => 'Nota crédito',
                '04' => 'Tiquete electrónico',
                /*'05' => 'Nota de despacho',
                '06' => 'Contrato',
                '07' => 'Procedimiento',
                '08' => 'Comprobante emitido en contingencia',
                '99' => 'Otro'*/
            ];
          
            $condicionVentas = [
                '01' => 'Contado',
                '02' => 'Crédito',

            ];

            $medioPagos = [
                '01' => 'Efectivo',
                '02' => 'Tarjeta',
                '03' => 'Cheque',
                '04' => 'Transferencia – depósito bancario'
            ];



            $view->with(compact('tipoDocumentos', 'condicionVentas', 'users','medioPagos'));
        });

       

        view()->composer(['receptors.create'], function ($view) {

            $MensajesReceptor = [
                '1' => 'Aceptado',
                '2' => 'Aceptado Parcialmente',
                '3' => 'Rechazado',
               
            ];

            $CondicionImpuesto = [
                '01' => 'Genera crédito IVA',
                '02' => 'Genera Crédito parcial del IVA',
                '03' => 'Bienes de Capital',
                '04' => 'Gasto corriente no genera crédito',
                '05' => 'Proporcionalidad',
                

            ];

            $view->with(compact('MensajesReceptor','CondicionImpuesto'));
        });

        view()->composer(['expenses._form'], function ($view) {

          
            $medioPagos = [
                '01' => 'Efectivo',
                '02' => 'Tarjeta',
                '03' => 'Cheque',
                '04' => 'Transferencia – depósito bancario'
            ];
           

            $view->with(compact('medioPagos'));
        });

        view()->composer(['invoices.index','electronicInvoice.index', 'proformas.index'], function ($view) {
            
            $sellers = User::all();

          

            $view->with(compact('sellers'));
        });
        

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register PDF facade alias for Laravel 11
        $loader = AliasLoader::getInstance();
        $loader->alias('PDF', \Barryvdh\DomPDF\Facade\Pdf::class);
    }
}
