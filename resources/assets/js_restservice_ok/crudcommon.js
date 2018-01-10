export default{
	methods: {
		fetchItems(item)
        {
			let uri = 'http://localhost:8000/'+item;
			this.axios.get(uri).then((response) => {
				return response.data;
			});
        },
        commonfunction(id)
        {
        	alert(id);
        }
    }
}