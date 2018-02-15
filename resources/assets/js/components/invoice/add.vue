<template>
    <div class="row">    
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Data Invoice</h3>
                </div>
                <div class="box-body">
                    <form class="form-horizontal">
                        <div class="col-sm-4">
                            <div class="form-group" v-bind:class="{'has-error' : errors.invoice_no}">
                                <label class="control-label col-sm-4" for="invoice_no">Invoice No:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="invoice_no" placeholder="Inovice Number" v-model="form.invoice_no">
                                    <span class="help-block" v-if="errors.invoice_no"><strong>{{ errors.invoice_no.join(", ") }}</strong></span>
                                </div>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error' : errors.client}">
                                <label class="control-label col-sm-4" for="client">Client</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client" placeholder="Client" v-model="form.client">
                                    <span class="help-block" v-if="errors.client"><strong>{{ errors.client.join(", ") }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" v-bind:class="{'has-error' : errors.client_address}">
                                <label class="control-label col-sm-4" for="client_address">Client Address:</label>
                                <div class="col-sm-8">
                                    <textarea cols="30" rows="4" id="client_address" class="form-control" v-model="form.client_address"></textarea>
                                    <span class="help-block" v-if="errors.client_address"><strong>{{ errors.client_address.join(", ") }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" v-bind:class="{'has-error' : errors.tittle}">
                                <label class="control-label col-sm-4" for="tittle">Tittle </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="tittle" placeholder="Tittle" v-model="form.tittle">
                                    <span class="help-block" v-if="errors.tittle"><strong>{{ errors.tittle.join(", ") }}</strong></span>
                                </div>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error' : errors.invoice_date}">
                                <label class="control-label col-sm-4" for="invoice_date">Invoice Date</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="invoice_date" v-model="form.invoice_date">
                                    <span class="help-block" v-if="errors.invoice_date"><strong>{{ errors.invoice_date.join(", ") }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                        
                        <div class="col-sm-12" v-if="errors.products_empty">
                            <div class="alert alert-danger">
                                <strong><i class="fa fa-warning"></i></strong> {{ errors.products_empty.join(", ") }}
                            </div>
                        </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th width="15%">Price</th>
                                    <th width="8%">Qty</th>
                                    <th width="15%">Total</th>
                                    <th width="3%" class="text-center"><i class="fa fa-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in form.products">
                                    <td :class="{'has-error': errors['products.' + index + '.name']}">
                                        <input type="text" class="form-control" v-model="product.name">
                                    </td>
                                    <td :class="{'has-error': errors['products.' + index + '.price']}">
                                        <input type="text" class="form-control" v-model="product.price" placeholder="Product Price">
                                    </td>
                                    <td :class="{'has-error': errors['products.' + index + '.qty']}">
                                        <input type="number" class="form-control" v-model="product.qty" placeholder="Product Price" min="1" max="10">
                                    </td>
                                    <td>
                                        <span class="form-control">{{ formatPrice(product.price * product.qty) }}</span>
                                    </td>
                                    <td >
                                        <button class="btn btn-xs btn-danger" v-on:click="removeLine(index)" type="button"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button class="btn btn-xs btn-link" type="button" v-on:click="addLine"><i class="fa fa-plus"></i> ADD LINE</button>
                                    </td>
                                    <td>Sub Total</td>
                                    <td><span class="form-control">{{ formatPrice(subTotal) }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Discount</td>
                                    <td><input type="number" class="form-control" v-model="form.discount" placeholder="Discount %" step="10" max="90" min="0"></td> 
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Grand Total</td>
                                    <td><span class="form-control">{{ formatPrice(grandTotal) }}</span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="col-sm-12">
                            <div class="form-group"> 
                                <div class="col-sm-10">
                                    <button type="button" v-on:click="storeInvoice" class="btn btn-sm btn-success"><i class="fa fa-floppy" ></i>Simpan</button>
                                    <router-link to="/system/invoice" tag="button" class="btn btn-sm btn-danger">Batal</router-link>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                form:{
                    products:[],
                    discount:0,
                },
                errors:{},
                
            }
        },
        components: {

        },
        methods: {
            addLine: function(){
                this.form.products.push({name: '', price: '', qty:1});
            },
            removeLine: function(index){
                this.form.products.splice(index);
            },
            storeInvoice: function(){
               var vm = this;
               axios.post('/invoice', this.form)
               .then(function(respon){
                    console.log(respon.data.created);
                    if (respon.data.created === true) {
                        vm.$router.push({ path : '/system/invoice'})
                    }
               })
               .catch(function(error){
                    vm.errors = error.response.data;
               });
            },
            formatPrice(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        },
        computed: {
            subTotal: function(){
                return this.form.products.reduce(function(carry, products){
                    return carry + (parseFloat(products.qty) * parseFloat(products.price));
                }, 0);
            },
            grandTotal: function(){
                return this.subTotal - ((parseFloat(this.form.discount)/100) * this.subTotal);
            }
        }

    }
</script>
