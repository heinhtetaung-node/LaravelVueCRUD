import config from './config.js';
var baseurl = config.baseurl;

export default{
	methods: {
         /*   for item */
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

         /*   for employess */
        fetchEmployees(action, obj, callback)
        {
        	let uri = baseurl+action;
            obj.axios.get(uri).then((response)=>{
                callback(response.data, obj);
            });
        },
        saveEmployee(action, para, obj, callback)
        {
            let uri = baseurl+action;
            // alert('hi update');
            // console.log(para);
            obj.axios.post(uri, para).then((response)=>{
                callback(response.data, obj);
            });
        },
        deleteEmployee(action, obj, callback)
        {
            let uri = baseurl+action;
            obj.axios.delete(uri).then((response)=>{
                callback(response.data, obj);
            });
        }
    }
}