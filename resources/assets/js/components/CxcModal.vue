<template>
    <div class="modal fade" id="cxcModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-primary text-white py-2">
                    <div>
                        <h5 class="modal-title mb-0">
                            <span class="oi oi-person mr-1"></span> Estado de Cuenta
                        </h5>
                        <small v-if="customer" class="opacity-75">{{ customer.name }}</small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" @click="clear()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Loading -->
                    <div v-if="loading" class="text-center py-5">
                        <div class="text-primary" style="font-size:2rem;">
                            <span class="oi oi-loop-circular"></span>
                        </div>
                        <p class="mt-2 text-muted">Cargando estado de cuenta&hellip;</p>
                    </div>

                    <!-- Error -->
                    <div v-else-if="error" class="alert alert-danger">
                        <h6 class="alert-heading mb-1">
                            <span class="oi oi-warning mr-1"></span> No se pudo cargar el estado de cuenta
                        </h6>
                        <p class="mb-0">{{ error }}</p>
                    </div>

                    <!-- Content -->
                    <template v-else-if="customer">

                        <!-- Resumen contable -->
                        <div class="row mb-3">
                            <div class="col-sm-4 mb-2">
                                <div class="card border-left-danger h-100 py-2 px-3" style="border-left:4px solid #dc3545 !important;">
                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size:0.7rem;">Total Facturado</small>
                                    <span class="h5 mb-0 font-weight-bold text-danger">{{ moneyFormat(totalDebito) }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <div class="card h-100 py-2 px-3" style="border-left:4px solid #28a745 !important;">
                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size:0.7rem;">Total Pagado</small>
                                    <span class="h5 mb-0 font-weight-bold text-success">{{ moneyFormat(totalCredito) }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <div class="card h-100 py-2 px-3" style="border-left:4px solid #ffc107 !important;">
                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size:0.7rem;">Saldo Pendiente</small>
                                    <span class="h5 mb-0 font-weight-bold text-warning">{{ moneyFormat(parseFloat(customer.TotalCxc)) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Libro mayor -->
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" style="font-size:0.875rem;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:14%">#Factura</th>
                                        <th style="width:12%">F. Emisión</th>
                                        <th style="width:12%">F. Vencimiento</th>
                                        <th class="text-right" style="width:12%">Débito</th>
                                        <th style="width:12%">F. Abono</th>
                                        <th class="text-right" style="width:12%">Crédito</th>
                                        <th class="text-right" style="width:12%">Saldo</th>
                                        <th class="text-center" style="width:14%">Días Vencidos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in items" :key="index"
                                        :class="rowClass(item)">

                                        <!-- #Factura -->
                                        <td v-if="item.type === 'D'" class="font-weight-bold">{{ item.description }}</td>
                                        <td v-else class="text-muted pl-4" style="font-style:italic;">↳ Abono</td>

                                        <!-- F. Emisión -->
                                        <td v-if="item.type === 'D'">{{ formatDate(item.date) }}</td>
                                        <td v-else></td>

                                        <!-- F. Vencimiento -->
                                        <td v-if="item.type === 'D'">{{ formatDueDate(item.dateVen) }}</td>
                                        <td v-else></td>

                                        <!-- Débito -->
                                        <td v-if="item.type === 'D'" class="text-right font-weight-bold text-danger">
                                            {{ moneyFormat(item.amount, '') }}
                                        </td>
                                        <td v-else></td>

                                        <!-- F. Abono -->
                                        <td v-if="item.type === 'C'" class="text-success">{{ formatDate(item.date) }}</td>
                                        <td v-else></td>

                                        <!-- Crédito (acumulado por factura para 'D', monto del abono para 'C') -->
                                        <td v-if="item.type === 'C'" class="text-right font-weight-bold text-success">
                                            {{ moneyFormat(Math.abs(item.amount), '') }}
                                        </td>
                                        <td v-else class="text-right text-muted">
                                            {{ getCredito(item.factura, item.type) }}
                                        </td>

                                        <!-- Saldo -->
                                        <td v-if="item.type === 'D'" class="text-right font-weight-bold">
                                            {{ getSaldo(item.factura) }}
                                        </td>
                                        <td v-else></td>

                                        <!-- Días Vencidos -->
                                        <td v-if="item.type === 'D'" class="text-center">
                                            <span v-if="dVencidos(item.dateVen) > 0"
                                                  class="badge badge-danger">
                                                {{ dVencidos(item.dateVen) }} días
                                            </span>
                                            <span v-else class="badge badge-success">Al día</span>
                                        </td>
                                        <td v-else></td>

                                    </tr>

                                    <!-- Fila total -->
                                    <tr class="table-secondary font-weight-bold">
                                        <td colspan="6" class="text-right">Saldo Total Pendiente:</td>
                                        <td class="text-right text-danger">
                                            {{ moneyFormat(parseFloat(customer.TotalCxc)) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                        </div>

                    </template>

                </div>

                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" @click="print()" :disabled="!customer">
                        <span class="oi oi-print mr-1"></span> Imprimir
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" @click="clear()">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import collection from '../mixins/collection'

    export default {

        data() {
            return {
                dataSet: false,
                q: '',
                customerId: false,
                customer: false,
                factura: [],
                tipo: '',
                loading: false,
                error: null,
            }
        },

        mixins: [collection],

        computed: {
            // Total facturado (débitos) de la página actual
            totalDebito() {
                if (!this.items) return 0;
                return this.items
                    .filter(i => i.type === 'D')
                    .reduce((sum, i) => sum + parseFloat(i.amount), 0);
            },
            // Total pagado (créditos, como positivo) de la página actual
            totalCredito() {
                if (!this.items) return 0;
                return this.items
                    .filter(i => i.type === 'C')
                    .reduce((sum, i) => sum + Math.abs(parseFloat(i.amount)), 0);
            },
        },

        methods: {

            /** Días vencidos. Devuelve 0 si dateVen no es una fecha válida. */
            dVencidos(feVen) {
                if (!feVen) return 0;
                const fechaVen = new Date(feVen);
                if (isNaN(fechaVen.getTime())) return 0; // "30 días", "45 días", etc.
                const today = new Date().toISOString().slice(0, 10);
                if (today <= feVen) return 0;
                const mili = new Date(today).getTime() - fechaVen.getTime();
                return Math.round(mili / 86400000);
            },

            /** Clase CSS de la fila según vencimiento */
            rowClass(item) {
                if (item.type !== 'D') return '';
                return this.dVencidos(item.dateVen) > 0 ? 'table-danger' : '';
            },

            /** Formatea una fecha datetime a dd/mm/yyyy */
            formatDate(dateStr) {
                if (!dateStr) return '';
                const d = new Date(dateStr);
                if (isNaN(d.getTime())) return dateStr;
                return d.toLocaleDateString('es-CR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            },

            /** Muestra la fecha de vencimiento: si es texto (ej: "30 días") lo deja tal cual */
            formatDueDate(dateVen) {
                if (!dateVen) return '';
                const d = new Date(dateVen);
                if (isNaN(d.getTime())) return dateVen; // texto como "30 días"
                return d.toLocaleDateString('es-CR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            },

            /** Limpia el estado al cerrar el modal */
            clear() {
                this.factura = [];
                this.customer = false;
                this.customerId = false;
                this.error = null;
                this.dataSet = false;
            },

            /** Ordena por número de factura */
            compare(a, b) {
                if (a.factura < b.factura) return -1;
                if (a.factura > b.factura) return 1;  // corregido: era a.factura > a.factura
                return 0;
            },

            /** Construye el array local de facturas con créditos acumulados */
            credito(items) {
                let x, y;
                for (x in items) {
                    if (items[x].type === 'D') {
                        this.factura.push({ num: items[x].factura, credito: 0, debito: items[x].amount });
                    } else {
                        for (y in this.factura) {
                            if (this.factura[y].num === items[x].factura) {
                                // amount de pagos viene negativo del servidor; restarlo da el crédito positivo
                                this.factura[y].credito -= items[x].amount;
                            }
                        }
                    }
                }
            },

            /** Devuelve el crédito acumulado de una factura */
            getCredito(numFactura, tipo) {
                for (let x in this.factura) {
                    if (numFactura === this.factura[x].num && tipo === 'D') {
                        return this.moneyFormat(this.factura[x].credito, '');
                    }
                }
                return '';
            },

            /** Devuelve el saldo de una factura */
            getSaldo(numFactura) {
                for (let x in this.factura) {
                    if (numFactura === this.factura[x].num) {
                        return this.moneyFormat(this.factura[x].debito - this.factura[x].credito, '');
                    }
                }
                return '';
            },

            moneyFormat(n, s = '₡') {
                if (typeof n === 'number') {
                    return s + n.format(2);
                }
                return s + n;
            },

            /** Imprime CxC o historial según el tipo */
            print() {
                if (this.tipo === 'cxc') {
                    window.open(`/customers/${this.customerId}/cxc/print`, 'name', 'width=800,height=400');
                } else {
                    window.open(`/customers/${this.customerId}/cxc/printP`, 'name', 'width=800,height=400');
                }
            },

            fetch(page) {
                this.loading = true;
                this.error = null;
                axios.get(this.url(page))
                    .then(this.refresh)
                    .catch((err) => {
                        if (err.response && err.response.status === 404) {
                            this.error = 'No se encontró el cliente. Verifique que la factura tenga un cliente asignado.';
                        } else if (err.response && err.response.status === 403) {
                            this.error = 'No tiene permisos para ver el estado de cuenta de este cliente.';
                        } else {
                            this.error = 'Ocurrió un error al cargar el estado de cuenta. Por favor intente de nuevo.';
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            url(page) {
                let url = `/customers/${this.customerId}/cxc`;
                url += `?page=${page || 1}`;
                return url;
            },

            refresh({ data }) {
                this.dataSet = data.data;
                this.items = data.data.data;
                this.customer = data.customer;
                this.factura = [];          // limpiar antes de reconstruir
                this.items.sort(this.compare);
                this.credito(this.items);
            },

        },

        created() {
            window.events.$on('showCxcModal', (data, tipo) => {
                // Validar que el customerId sea un valor válido y no cero
                if (!data || data === '0' || data === 0) {
                    this.error = 'Esta factura no tiene un cliente asociado. No se puede mostrar el estado de cuenta.';
                    this.loading = false;
                    return;
                }
                this.customerId = data;
                this.tipo = tipo;
                this.fetch();
            });

            window.events.$on('closeCxcModal', () => {
                this.clear();
            });
        },

    }
</script>

