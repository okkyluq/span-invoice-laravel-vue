<template>
    <div class="row">    
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Invoice</h3>
                </div>
                <div class="box-body">
                    <div style="margin-bottom: 40px;">
                        <div class="pull-left">
                             <router-link to="/system/invoice/add" tag="button" class="btn btn-sm btn-success">Tambah Data</router-link>
                        </div>
                        <div class="pull-right">
                            <input type="text" class="form-control" placeholder="Cari Berdasarkan No.Invoice" v-model="search" v-on:keyup="filter">
                        </div>
                    </div>
                    
                   <!--  <autocomplete
                        url="/auto/invoice"
                        anchor="client"
                        label="invoice_no"
                        placeholder="placeholder autocomplete"
                        :on-select="getData">
                    </autocomplete> -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">Invoice No.</th>
                                <th width="20%">Client</th>
                                <th>Client Address</th>
                                <th width="15%">Tittle</th>
                                <th width="10%">Created at</th>
                                <th width="10%" class="text-center"><i class="fa fa-gear"></i></th>
                            </tr>
                        </thead>    
                        <tbody>
                            <tr v-for="item in items">
                                <td>{{ item.invoice_no }}</td>
                                <td>{{ item.client }}</td>
                                <td>{{ item.client_address }}</td>
                                <td>{{ item.tittle }}</td>
                                <td>{{ item.created_at | moment("D/M/Y") }}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'invoice_detail', params: {id : item.id }}" class="btn btn-xs btn-info" type="button"><i class="fa fa-eye"></i></router-link>
                                    <router-link :to="{name: 'invoice_edit', params : {id : item.id }}" class="btn btn-xs btn-success" type="button"><i class="fa fa-edit"></i></router-link>
                                    <button class="btn btn-xs btn-danger" type="button" v-on:click="hapusInvoice(item.id, item.invoice_no)"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                            <button class="btn btn-default" v-on:click="prev" v-bind:disabled="!page.prev_page_url">Prev</button>
                            <button class="btn btn-default" v-on:click="next" v-bind:disabled="!page.next_page_url">Next</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Autocomplete from 'vue2-autocomplete-js'
    require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css')
    export default {
        data(){
            return {
                search:'',
                items:{},
                page:{},
            }
        },
        mounted() {
            this.getInvoice();
        },
        components: { Autocomplete },
        methods: {
            getInvoice: function(){
                var vm = this;
                axios.get('/data/invoice')
                .then(function(respon){
                    vm.page = respon.data;
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            getData: function(obj){
                console.log(obj);
            },
            filter: function(){
                var vm = this;
                axios.get('/data/invoice?search='+this.search)
                .then(function(respon){
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            prev: function(){
                var vm = this;
                axios.get(this.page.prev_page_url)
                .then(function(respon){
                    vm.page = respon.data;
                    vm.items = respon.data.data;
                });
            },
            next: function(){
                var vm = this;
                axios.get(this.page.next_page_url)
                .then(function(respon){
                    vm.page = respon.data;
                    vm.items = respon.data.data;
                });
            },
            hapusInvoice: function(id, id_invoice){
                this.$swal({
                          title: 'Apakah Anda Serius',
                          text: "Menghapus Invoice No. "+id_invoice,
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                var vm = this;
                                axios.delete('/invoice/'+id)
                                .then(function(respon){
                                    vm.getInvoice();
                                    if(respon.data.deleted === true){
                                        vm.$swal('Deleted!', 'Your file has been deleted.', 'success');
                                    }
                                })
                                .catch(function(error){
                                    console.log(error)
                                });
                            }
                        })
            },

        }

    }
</script>
