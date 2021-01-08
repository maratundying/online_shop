<style>
	table{
		text-align: center; 
		border-collapse: collapse;
		/*width:800px !important;*/
	}
	
	td,tr,th{
		text-align: center;
		font-size: 1em;
		border: 1px solid grey;
	}


</style>
<template>
	<div class="table-responsive container" id="div" >
		<table class="table" v-if='products.length>0' align='center' >
			<thead>
				<th>Product</th>
				<th>Price</th>
				<th>Count</th>
				<th>Description</th>
				<th>Seller</th>
				<th colspan="2">Actions</th>
			</thead>
			<tbody >
				<tr v-for='(i,index) in products' v-if='product[index].activated==1'>
					<td ><a :href="'/item/'+i.id">{{i.name}}</a></td>
					<td>{{i.price}}$</td>
					<td>{{i.count}}</td>
					<td>{{i.description}}</td>
					<td><a :href="'/user/'+i.user_id">To seller account</a></td>
					<td><button @click='confirm(i,index)' v-if='product[index].bool==true'>Confirm</button>
					<button @click='opencancel(i,index)' v-if='product[index].bool==true'>Cancel</button>
					<input type="text" v-model='product[index].inputval' v-if='product[index].bool==false'>
					<button @click='send(i,index)' v-if='product[index].bool==false'>Send</button>
				</td>
				</tr>
			</tbody>
		</table>
		<div class="alert alert-danger text-center" v-else>Nothing to show</div>
	</div>
	</template>

<script>
	export default{
		props:['products'],
		data(){
			return {
				product:[]
			}
		},

		mounted(){
			for(let i=0;i<this.products.length;i++){
				this.product.push({bool:true,inputval:'',activated:1})
			}
			console.log(this.product)
		},
		methods:{
			opencancel(i,index){
				this.product[index].bool=false
			},

			confirm(i,index){
				axios.post('/confirmProduct',{id:i.id}).
				then((r)=>{
					// this.product[index].activated=2
					this.product[index].bool=true
					this.product[index].activated=2
					console.log(this.product)
				}).
				catch((r)=>{
					console.log(r)
				})
			},

			send(i,index){
				axios.post('/sendReason',{id:i.id,reason:this.product[index].inputval,user_id:i.user_id}).
				then((r)=>{
					this.product[index].bool=true
					this.product[index].activated=0

				})
			},

			opencancel(i,index){
				this.product[index].bool=false
			},
		}
	}
</script>