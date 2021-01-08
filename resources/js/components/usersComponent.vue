<style>
	#buttondiv{
		display: inline-block;
		margin:auto;
		min-width:20px;
	};
</style>

<template>
			<!-- <strong>{{i.name}} {{i.surname}}</strong>
			<button  @click='toggle(index)' v-if='String(Date.now()).substring(0,String(Date.now()).length-3)>users[index].blocked'>Block</button>
			<button  @click='unblock(index)' v-if='String(Date.now()).substring(0,String(Date.now()).length-3)<users[index].blocked'>Unblock</button>
			<div v-if='!user[index].bool'>
				<input type="text" v-model="user[index].inputval">
				<button @click='save(index)'>Save</button>
			</div> -->
		<div class="table-responsive container" id="div" >
		<table class="table" v-if='users.length>0' align='center' >
			<th>№</th>
			<th>Name</th>
			<th>Surname</th>
			<th>User account</th>
			<th>Blocked</th>
			<th>Buttons</th>
			<tr v-for='(i,index) in users'>
				<td>{{index+1}}</td>
				<td>{{i.name}}</td>
				<td>{{i.surname}}</td>
				<td><a :href="'/user/'+i.id">To user account</a></td>
				<td>
					<span v-if="String(Date.now()).substring(0,String(Date.now()).length-3)<users[index].blocked || user[index].blocked==true">{{users[index].blocked-String(Date.now()).substring(0,String(Date.now()).length-3)}} Sec.</span>
					<span v-else>-</span>
				</td>
				<td colspan="2">
					<button  @click='toggle(index)' v-if='users[index].blocked-String(Date.now()).substring(0,String(Date.now()).length-3)<=0 || user[index].blocked==false'>Block</button>
					<button  @click='unblock(index)' v-if='users[index].blocked-String(Date.now()).substring(0,String(Date.now()).length-3)>0 || user[index].blocked==true'>Unblock</button></td>
				</td>
				<td v-if='!user[index].bool' id="buttondiv">
					<input type="text" v-model="user[index].inputval">
					<button @click='save(index)'>Save</button>
				</td>
			</tr>
		</table>
		<div class="alert alert-danger text-center" v-else>Nothing to show</div>
	</div>
</template>

<script>
	export default{
		props:['users'],
		data(){
			return {user:[]}
		},

		mounted(){
			for(let i=0;i<this.users.length;i++){
				this.user.push({bool:true,inputval:'',blocked:false})
			}
			console.log(this.users)
			console.log(this.users[0].blocked-String(Date.now()).substring(0,String(Date.now()).length-3))
		},

		methods:{
			toggle(i){
				this.user[i].bool=false	
			},

			save(i){
				axios.post('/block',{id:this.users[i].id,time:this.user[i].inputval}).
				then((response)=>{
					console.log(response.data)
					let now=+(String(Date.now()).substring(0,String(Date.now()).length-3))
					this.users[i].blocked=response.data
					this.user[i].bool=true
					this.user[i].blocked=true
				}).
				catch((errors)=>{
					
				})
			},

			unblock(i){
				axios.post('/unblock',{id:this.users[i].id}).
				then((r)=>{
					this.user[i].blocked=false
					this.users[i].blocked=0;
					console.log(this.user[i])
				}).
				catch((r)=>{
					console.log(r)
				})
			}
		}
	}
</script>
