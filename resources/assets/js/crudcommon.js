export default{
	methods: {
		fetchItems(item)
        {
			let uri = 'http://127.0.0.1:8000/'+item;
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
