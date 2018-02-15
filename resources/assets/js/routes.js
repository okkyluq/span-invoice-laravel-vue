import VueRouter from 'vue-router'

let routes = [
		
		{
			path: '/system/dashboard',
			component : require('./components/dashboard.vue')
		},


		{
			path: '/system/mahasiswa',
			component : require('./components/mahasiswa/index.vue')
		},
		{
			path: '/system/mahasiswa/add',
			component : require('./components/mahasiswa/add.vue')
		},



		{
			path: '/system/invoice',
			component : require('./components/invoice/index.vue')
		},
		{
			path: '/system/invoice/add',
			component : require('./components/invoice/add.vue')
		},
		{
			path: '/system/invoice/:id',
			name: 'invoice_detail',
			component : require('./components/invoice/detail.vue')
		},
		{
			path: '/system/invoice/:id/edit',
			name: 'invoice_edit',
			component : require('./components/invoice/edit.vue')
		}



	
]


export default new VueRouter({
	routes,
	mode: 'history',
});