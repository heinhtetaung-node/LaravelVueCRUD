import config from './config.js';
var baseurl = config.baseurl;

export default{
	methods: {
		fetchItems(action, obj, callback)
        {
            let uri = baseurl+action;
            obj.axios.get(uri).then((response) => {
                callback(response.data, obj);
            });
        },
        saveItems(action, para, obj, callback)
        {
            let uri = baseurl+action;
            obj.axios.post(uri, para).then((response) => {
                if(response.result==false){
                    callback(response, obj);
                }
                callback(response.data, obj);
            });
        },
        deleteItem(action, obj, callback)
        {
            let uri = baseurl+action;
            obj.axios.delete(uri).then((response) => {
                callback(response.data, obj);
            });
        },
        commonfunction(id)
        {
        	alert(id);
        }
    }
}