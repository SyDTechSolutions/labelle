<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductBarcodeController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ConfigFacturaController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotaCreditoController;
use App\Http\Controllers\NotaDebitoController;
use App\Http\Controllers\PaymentInvoiceController;
use App\Http\Controllers\ReportCxPController;
use App\Http\Controllers\ReportCxCController;
use App\Http\Controllers\ReportInvoiceController;
use App\Http\Controllers\ReportFacturasProveedorController;
use App\Http\Controllers\ReportProductController;
use App\Http\Controllers\ReportSellerInvoiceController;
use App\Http\Controllers\ReportCustomerInvoiceController;
use App\Http\Controllers\ReportExpensesController;
use App\Http\Controllers\ReceptorController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\ReportUserController;
use App\Http\Controllers\CxCController;
use App\Http\Controllers\CustomerCxCController;
use App\Http\Controllers\ProviderCxpController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentPurchaseController;
use App\Http\Controllers\CxPController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductProviderController;
use App\Http\Controllers\ProformaPurchaseController;
use App\Http\Controllers\ProductProviderProformaPurchaseController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajasController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\ElectronicInvoiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Ruta para renovar token CSRF
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Aplicar middleware de tipo de app a todas las rutas web autenticadas
Route::middleware(['auth', 'app.type'])->group(function () {

// Route::get('/pdf', function ()
// {
//     //$pdf = PDF::loadHTML('<h1>Test</h1>');
//     $pdf = PDF::loadHTML('<h1>Test</h1>');
//     Mail::to('alonso@avotz.com')->send(new SendProforma($pdf->output()));
//     // Mail::send(['text' => 'mail'], [], function ($message) {

//     //     $pdf = PDF::loadHTML('<h1>Test</h1>');

//     //     $message->to('alonso@avotz.com', 'John Smith')->subject('Send Mail from Laravel');

//     //     $message->from('from@gmail.com', 'The Sender');

//     //     $message->attachData($pdf->output(), 'proforma.pdf');

//     // });
//    // return $pdf->output();
// });
Route::get('/storageLink', function(){
    Artisan::call('storage:link');
});

Route::get('/inventariocero', [SettingController::class, 'showInventarioCero']);
Route::post('/inventariocero', [SettingController::class, 'setInventarioCero']);

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('providers', ProviderController::class);

Route::post('products/export', [ProductController::class, 'export']);
Route::post('products/import', [ProductController::class, 'import']);

Route::get('products/{product}/barcodes/print', [ProductBarcodeController::class, 'print']);
Route::get('products/barcodes/print', [ProductBarcodeController::class, 'printLote']);
Route::put('products/{product}/quantity', [ProductController::class, 'updateQuantity']);
Route::post('products/{product}/duplicate', [ProductController::class, 'duplicate']);
Route::resource('products', ProductController::class);
Route::resource('taxes', TaxController::class);
Route::resource('currencies', CurrencyController::class);
Route::get('/settings', [SettingController::class, 'edit']);
Route::patch('/settings', [SettingController::class, 'update']);
Route::post('/settings/{setting}/configfactura', [ConfigFacturaController::class, 'store']);
Route::put('/configfactura/{config}', [ConfigFacturaController::class, 'update']);
Route::delete('/configfactura/{config}', [ConfigFacturaController::class, 'destroy']);

Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print']);
Route::get('/invoices/{invoice}/ticket', [InvoiceController::class, 'ticket']);
Route::post('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf']);
Route::get('/invoices/{invoice}/recibopago', [InvoiceController::class, 'reciboPago']);
Route::get('/invoices/{invoice}/notacredito', [NotaCreditoController::class, 'create']);
Route::post('/invoices/{invoice}/notacredito', [NotaCreditoController::class, 'store']);
Route::get('/invoices/{invoice}/notadebito', [NotaDebitoController::class, 'create']);
Route::post('/invoices/{invoice}/notadebito', [NotaDebitoController::class, 'store']);
Route::get('/invoices/{invoice}/payments', [PaymentInvoiceController::class, 'index']);
Route::post('/invoices/{invoice}/payments', [PaymentInvoiceController::class, 'store']);
Route::put('/invoices/{invoice}/sendhacienda', [InvoiceController::class, 'sendhacienda']);
Route::get('/invoices/{invoice}/download/xml', [InvoiceController::class, 'xml']);
Route::delete('/payments/{payment}', [PaymentInvoiceController::class, 'destroy']);
Route::get('/reports/cxps/expired', [ReportCxPController::class, 'index']);
Route::get('/reports/cxcs/expired', [ReportCxCController::class, 'index']);
Route::get('/reports/invoices/summary', [ReportInvoiceController::class, 'summary']);
Route::get('/reports/invoices', [ReportInvoiceController::class, 'index']);
Route::get('/reports/facturasProveedor', [ReportFacturasProveedorController::class, 'index']);
Route::get('/reports/products/sold', [ReportProductController::class, 'index']);
Route::get('/reports/sellers/invoices', [ReportSellerInvoiceController::class, 'index']);
Route::get('/reports/customers/invoices', [ReportCustomerInvoiceController::class, 'index']);

Route::put('/invoices/{invoice}/cancel', [InvoiceController::class, 'cancel']);
Route::put('/invoices/{invoice}/updateseller', [InvoiceController::class, 'updateSeller']);
Route::resource('invoices', InvoiceController::class);

Route::get('/reports/expenses', [ReportExpensesController::class, 'index']);

Route::get('/receptor/mensajes', [ReceptorController::class, 'index']);
Route::get('/receptor/mensajes/create', [ReceptorController::class, 'create']);
Route::post('/receptor/mensajes', [ReceptorController::class, 'store']);
Route::post('/receptor/mensajes/uploadxml', [ReceptorController::class, 'uploadXml']);
Route::put('/receptor/mensajes/{receptor}/sendhacienda', [ReceptorController::class, 'sendhacienda']);
Route::delete('/receptor/mensajes/{receptor}', [ReceptorController::class, 'destroy']);
Route::get('/hacienda/mensaje/{receptor}/recepcion', [HaciendaController::class, 'recepcionMensaje']);
Route::get('/hacienda/mensaje/{receptor}/xml', [HaciendaController::class, 'xmlMensaje']); // mensaje hacienda xml

Route::post('/receptor/mensajes/lote', [ReceptorController::class, 'lote']);
Route::get('/reports/expenses/user', [ReportUserController::class, 'index']);
Route::get('/reports/receptors', [ReceptorController::class, 'report']);

Route::get('/hacienda/{invoice}/recepcion', [HaciendaController::class, 'recepcion']);
Route::get('/hacienda/{invoice}/recepcioncompra', [HaciendaController::class, 'recepcionCompra']);
Route::get('/hacienda/{invoice}/xml', [HaciendaController::class, 'xml']); // mensaje hacienda xml
Route::get('/hacienda/{invoice}/xmlcompra', [HaciendaController::class, 'xmlCompra']);
Route::post('/hacienda/response', [HaciendaController::class, 'haciendaResponse'])->name('haciendaresponse');
Route::post('/hacienda/mensaje/response', [HaciendaController::class, 'haciendaMensajeResponse'])->name('haciendamensajeresponse');

Route::get('/cxc/{invoice}/print', [CxCController::class, 'print']);
Route::get('/cxc/Pagadas', [CxCController::class, 'pagadas']);
Route::get('/cxc', [CxCController::class, 'index']);

Route::post('customers/export', [CustomerController::class, 'export']);
Route::post('customers/import', [CustomerController::class, 'import']);

Route::get('/customers/{customer}/cxc', [CustomerCxCController::class, 'index']);
Route::get('/customers/{customer}/cxc/print', [CustomerCxCController::class, 'print']);
Route::get('/customers/{customer}/cxc/printP', [CustomerCxCController::class, 'printPagadas']);

Route::get('/purchases/{purchase}/cxp', [ProviderCxpController::class, 'index']);
Route::get('/purchases/{purchase}/cxp/print', [ProviderCxpController::class, 'print']);
Route::get('/purchases/{purchase}/cxp/printP', [ProviderCxpController::class, 'printPagadas']);

Route::get('/proformas/{proforma}/print', [ProformaController::class, 'print']);
Route::get('/proformas/{proforma}/ticket', [ProformaController::class, 'ticket']);
Route::get('/proformas/{proforma}/testpdf', [ProformaController::class, 'testpdf']);
Route::post('/proformas/{proforma}/pdf', [ProformaController::class, 'pdf']);
Route::put('/proformas/{proforma}/updateseller', [ProformaController::class, 'updateSeller']);
Route::put('/invoices/{proforma}/updateProforma', [InvoiceController::class, 'updateProforma']);
Route::resource('proformas', ProformaController::class);

Route::get('/purchases/{purchase}/print', [PurchaseController::class, 'print']);
Route::get('/purchases/{purchase}/ticket', [PurchaseController::class, 'ticket']);
Route::get('/purchases/{purchase}/testpdf', [PurchaseController::class, 'testpdf']);
Route::post('/purchases/{purchase}/pdf', [PurchaseController::class, 'pdf']);
Route::get('/purchases/{purchase}/payments', [PaymentPurchaseController::class, 'index']);
Route::post('/purchases/{purchase}/payments', [PaymentPurchaseController::class, 'store']);
Route::delete('/purchasepayments/{payment}', [PaymentPurchaseController::class, 'destroy']);
Route::get('/purchases/check', [PurchaseController::class, 'check']);
Route::resource('purchases', PurchaseController::class);

Route::get('/cxp/{purchase}/print', [CxPController::class, 'print']);
Route::get('/cxp/contado', [CxPController::class, 'indexContado']);
Route::get('/cxp', [CxPController::class, 'index']);
Route::get('/cxp/{purchase}', [CxPController::class, 'indexInfo']);

Route::get('/expenses/last', [ExpenseController::class, 'lastFromCierre']);
Route::resource('expenses', ExpenseController::class);


Route::resource('productproviders', ProductProviderController::class);

Route::get('/proformapurchases/{proformapurchase}/print', [ProformaPurchaseController::class, 'print']);
Route::get('/proformapurchases/{proformapurchase}/ticket', [ProformaPurchaseController::class, 'ticket']);
Route::post('/proformapurchases/{proformapurchase}/pdf', [ProformaPurchaseController::class, 'pdf']);
Route::resource('proformapurchases', ProformaPurchaseController::class);

Route::post('/productproviders/{productprovider}/proformapurchases', [ProductProviderProformaPurchaseController::class, 'store']);

Route::post('/cajas', [CajaController::class, 'store']);
Route::get('/cajas/today', [CajaController::class, 'show']);
Route::put('/cajas/{caja}', [CajaController::class, 'update']);

Route::get('/caja', [CajasController::class, 'index']);
Route::delete('/caja/{proforma}', [CajasController::class, 'destroy']);

Route::resource('contabilidad', ContabilidadController::class);

Route::put('/electronicinvoice/{invoice}/sendhacienda', [ElectronicInvoiceController::class, 'sendhacienda']);
Route::get('/electronicinvoice/{invoice}/download/xml', [ElectronicInvoiceController::class, 'xml']);
Route::post('/electronicinvoice/{invoice}/pdf', [ElectronicInvoiceController::class, 'pdf']);
Route::get('/electronicinvoice/{invoice}/print', [ElectronicInvoiceController::class, 'print']);
Route::get('/electronicinvoice/{invoice}/ticket', [ElectronicInvoiceController::class, 'ticket']);
Route::resource('electronicinvoice', ElectronicInvoiceController::class);

}); // Fin del middleware group app.type

// LZL6OBy>1u EZACR