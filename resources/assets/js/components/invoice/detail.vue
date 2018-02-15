<template>
    <div class="row">    
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Data Invoice</h3>
                    <div class="pull-right">
                        <router-link to="/system/invoice" tag="button" class="btn btn-sm btn-danger"><i class="fa fa-arrow-circle-left"></i> Kembali</router-link>
                    </div>
                </div>
                <div class="box-body">
                <section class="invoice">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                        <i class="fa fa-globe"></i> Toko Serba Ada, Inc.
                        <small class="pull-right">Date : {{ invoice.created_at | moment("D/M/Y") }}</small>
                        </h2>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                        <strong>{{ invoice.client }}</strong><br>
                        {{ invoice.client_address }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Tittle : {{ invoice.tittle }}</b><br>
                        <b>Invoice : {{ invoice.invoice_no }}</b><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name Product</th>
                                    <th width="10%">Price</th>
                                    <th width="5%">Qty</th>
                                    <th width="10%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in invoice.products">
                                    <td>{{ product.name }}</td>
                                    <td>Rp. {{ formatPrice(product.price) }}</td>
                                    <td>{{ product.qty }}</td>
                                    <td>Rp. {{ formatPrice(product.total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <p class="lead">Payment Methods:</p>
                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <p class="lead">Amount Due {{ invoice.created_at | moment("D/M/Y") }}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>Rp. {{ formatPrice(invoice.sub_total) }}</td>
                                </tr>
                                <tr>
                                <th>Discount:</th>
                                <td>{{ formatPrice(invoice.discount) }} %</td>
                                </tr>
                                <tr>
                                <th>Total:</th>
                                <td>Rp. {{ formatPrice(invoice.grand_total) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                        </button>
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                        <i class="fa fa-download"></i> Generate PDF
                        </button>
                    </div>
                </div>
                </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric'

    export default {
        data(){
            return {
                id: this.$route.params.id,
                invoice: {
                }
            }
        },
        components: {
            VueNumeric,
        },
        mounted() {
            this.detailInvoice();
        },
        methods: {
            detailInvoice: function(){
                var vm = this;
                axios.get('/invoice/'+vm.id)
                .then(function(respon){
                    vm.invoice = respon.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            formatPrice: function(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        },
        computed: {
            
        }

    }
</script>
