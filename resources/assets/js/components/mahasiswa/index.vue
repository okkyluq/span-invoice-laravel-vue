<template>
    <div class="row">    
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Mahasiswa</h3>
                </div>
                <div class="box-body">
                    <div class="pull-left">
                         <router-link to="/system/mahasiswa/add" tag="button" class="btn btn-sm btn-success">Tambah Data</router-link>
                    </div>
                    <div class="pull-right">
                        <input type="text" class="form-control" placeholder="Cari Berdasarkan Nama" v-model="cari" v-on:keyup="filter">
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">NIM</th>
                                <th>Nama</th>
                                <th width="12%">Tempat Lahir</th>
                                <th width="15%" class="text-center">Tanggal Input</th>
                                <th width="8%" class="text-center">Action</th>
                            </tr>
                        </thead>    
                        <tbody>
                            <tr v-for="item in items">
                                <td>{{ item.nim }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ item.tempat_lahir }}</td>
                                <td>{{ item.created_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" type="button"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pull-left">
                        <p style="margin-top:10px;">Total Data :     <strong>{{page_info.total}}</strong></p>
                    </div>
                    <div class="pull-right">
                        <ul class="pagination">
                            <li><button type="button" class="btn btn-sm btn-default" v-on:click="prev" v-bind:disabled="!this.page_info.prev_page_url"><span class="fa fa-angle-left"></span> Prev</button></li>
                            <li><button type="button" class="btn btn-sm btn-default" v-on:click="next" v-bind:disabled="!this.page_info.next_page_url"><span class="fa fa-angle-right"></span> Next</button></li>
                        </ul>
                    </div>
                </div>
                <div class="box-footer">
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                items:{},
                page_info:{},
                cari:''
            }
        },
        mounted() {

        },
        created(){
            this.getDataMahasiswa()
        },
        methods: {
            getDataMahasiswa(){
                var vm = this
                axios.get('/data/mahasiswa')
                .then(function(respon){
                    vm.page_info = respon.data;
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error);
                })
            },
            prev(){
                var vm = this
                axios.get(this.page_info.prev_page_url)
                .then(function(respon){
                    vm.page_info = respon.data;
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error);
                })
            },
            next(){
                var vm = this
                axios.get(this.page_info.next_page_url)
                .then(function(respon){
                    vm.page_info = respon.data;
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error);
                })
            },
            filter(){
                var vm = this
                axios.get("/data/mahasiswa?cari="+this.cari)
                .then(function(respon){
                    vm.page_info = respon.data;
                    vm.items = respon.data.data;
                })
                .catch(function(error){
                    console.log(error);
                })
            }
        }

    }
</script>
