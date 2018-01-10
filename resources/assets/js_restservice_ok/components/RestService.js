export default{
	methods: {
		fetchItems(item, obj)
        {
            let uri = 'http://localhost:8000/'+item;
			obj.axios.get(uri).then((response) => {
                //console.log(response.data);
				obj.items = response.data;
                //debugger;
			});
        },
        commonfunction(id)
        {
        	alert(id);
        }
    }
}