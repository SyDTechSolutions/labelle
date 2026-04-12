<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Arr;

class Invoice extends Model
{
    protected $guarded = ['lines','referencias', 'TipoDocumentoName', 'CondicionVentaName', 'MedioPagoName','Pending', 'initialPayment','payments'];

    protected $appends = ['TipoDocumentoName', 'CondicionVentaName', 'MedioPagoName','Pending'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $casts = [
        'fe' => 'integer',
        'status' => 'integer',
       // 'TotalWithNota' => 'float',
        /*'TipoCambio' => 'float',
        'TotalServGravados' => 'float',
        'TotalServExentos' => 'float',
        'TotalMercanciasGravadas' => 'float',
        'TotalMercanciasExentas' => 'float',
        'TotalGravado' => 'float',
        'TotalExento' => 'float',
        'TotalVenta' => 'float',
        'TotalDescuentos' => 'float',
        'TotalVentaNeta' => 'float',
        'TotalImpuesto' => 'float',
        'TotalComprobante' => 'float',*/
    ];

    public function getPendingAttribute()
    {
        return $this->TotalComprobante - $this->payments->sum('amount');
    }
   
    public function getTipoDocumentoNameAttribute()
    {
        return trans('utils.tipo_documento.' . $this->TipoDocumento);
    }
    public function getCondicionVentaNameAttribute()
    {
        return trans('utils.condicion_venta.' . $this->CondicionVenta);
    }
    public function getMedioPagoNameAttribute()
    {
        return trans('utils.medio_pago.' . $this->MedioPago);
    }

    public function getCreatedAtFormatAttribute(){
        return $this->created_at->format('Y-m-d');
    }


    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {
            
            $query = $query->where(function ($query) use ($search) {
                $query->where('invoices.cliente', 'like', '%' . $search['q'] . '%')
                    ->orWhere('invoices.identificacion_cliente', 'like', '%' . $search['q'] . '%')
                    ->orWhere('invoices.consecutivo', 'like', '%' . $search['q'] . '%')
                    ->orWhere('invoices.NumeroConsecutivo', 'like', '%' . $search['q'] . '%');
            });
        }

        if(isset($search['start']) && $search['start']){
            $start = new Carbon($search['start']);
            $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
            $end = new Carbon($end);

            $query = $query->where([
                ['invoices.created_at', '>=', $start],
                ['invoices.created_at', '<=', $end->endOfDay()]
            ]);
        }

        if (isset($search['type']) && $search['type']) {

            $query = $query->where('invoices.TipoDocumento', $search['type']);
                   
           
        }
        if (isset($search['condicion']) && $search['condicion']) {

            $query = $query->where('invoices.CondicionVenta', $search['condicion']);


        }
        if (isset($search['sent_to_hacienda']) && !is_blank($search['sent_to_hacienda'])) {

            $query = $query->where('invoices.sent_to_hacienda', $search['sent_to_hacienda']);
                   
           
        }
        if (isset($search['status_fe']) && $search['status_fe']) {

            $query = $query->where('invoices.status_fe', $search['status_fe']);


        }

        if (isset($search['created_by']) && $search['created_by']) {

            $query = $query->where('invoices.created_by', $search['created_by']);


        }

        if (isset($search['MedioPago']) && $search['MedioPago']) {

            $query = $query->where('invoices.MedioPago', $search['MedioPago']);


        }
        

        return $query;
    }

    public function lines()
    {
        return $this->hasMany(InvoiceLine::class);
    }
    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }
    public function payments() //abonos
    {
        return $this->hasMany(Payment::class);
    }
    public function notascreditodebito()
    {
        return $this->hasMany(Referencia::class,'referencia_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function obligadoTributario()
    {
        return $this->belongsTo(ConfigFactura::class, 'obligado_tributario_id');
    }
    

    public function saveLines($items)
    {
       
       
        foreach ($items as $item) {

            $item = Arr::except($item, array('id', 'invoice_id'));

            $line = $this->lines()->create($item);
            
            // Remove 'id' from each tax to avoid duplicate key errors
            $taxes = collect($item['taxes'])->map(function ($tax) {
                return Arr::except($tax, ['id', 'invoice_line_id']);
            })->toArray();
            
            $line->saveTaxes($taxes);

           

        }

        return $this;
    }

    public function saveReferencias($referencias)
    {
        foreach ($referencias as $ref) {

            $referencia = $this->referencias()->create($ref);

        }

        return $this;

    }

    public function calculatePendingAmount()
    {
        $paymentsAmount = 0;
    
        $paymentsAmount = $this->payments->sum('amount');

        $pending = $this->TotalComprobante - $paymentsAmount;

        $this->update([
            'cxc_pending_amount' => ($pending < 0) ? 0 : $pending
        ]);
        
    }
}
