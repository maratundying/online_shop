<style>
	#menubody{
		display:flex;
		flex-wrap:wrap;
		align-items:center;
		justify-content:center;
	}

	#menubody>*{
		display:inline-block;
		margin-left:10px;
	}
</style>
<template>
	<div id='menubody'>
		<router-link to='/admindashboard/users'>Users</router-link>
		<router-link to='/admindashboard/products'>Products</router-link>
		<hr>
	</div>
</template>