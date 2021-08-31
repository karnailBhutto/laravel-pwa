function loadData() {	

	var URL=window.location.href;
	var arr=URL.split('/');//arr[0]='example.com //arr[1]='event'//arr[2]='14aD9Uxp?p=10'

	var parameter=arr[arr.length-1].split('?');//parameter[0]='14aD9Uxp' //parameter[1]='p=10
	var p_value=parameter[1].split('=')[1];//p_value='10';
	
	localforage.config({
		driver: localforage.INDEXEDDB,
	});
	
	var register = localforage.createInstance({
		name: "sfa-kh",
		storeName: "outlets-update"
	});
	
	var order = localforage.createInstance({
		name: "sfa-kh",
		storeName: "orders"
	});
		
	var keyval = 'outlet_' + p_value; //alert(keyval);
	var keyor = 'order_' + p_value; 
	
	function padZerosToLength (value, minLength, padChar) {
		var iValLength= value.toString().length;
		return ((new Array((minLength + 1) - iValLength).join(padChar)) + value);
	}

	$(document).ready(function(e){ //alert('order-history');
		register.getItem(keyval).then(function (value) { //console.log(value);
			document.getElementById('outletid').innerHTML = 'Outlet ID :'+padZerosToLength(value.outletid, 11, 0);
			document.getElementById("outlet_sname").innerHTML = 'Outlet Name : '+value.outlet_sname;
			//alert(value.token);

		}).catch(function(err) {
			console.error(err);
		});
	});
	
	$(document).on('click','#create',function(e){ //alert('lalu')
		e.preventDefault();
		
		register.getItem(keyval).then(function (value) {  
		e.preventDefault();
		
			var getOrder = {
				outlet_id : p_value,
				order_empty : 2,
				order_status : "",
				token : value.token,
				created_at : new Date().toLocaleString()
			}
			
			order.setItem(keyor,getOrder).then(function (val) {
				console.log(val); 
				window.location = "https://sfa-staging.vindagroupsea.com/addnew?id="+value.outletid;
			})
		}).catch(function(err) {
			console.error(err);
		});
	});
	
}

//$("input[name^='hidden['],textarea[name^='hidden[']").each(function() {

// var fields ={};                                                   
// $('input[name^="carton["],input[name^="packs["],input[name^="sku["]').each(function(){
	// fields[$(this).attr('name').replace('[', '').replace(']', '')] = $(this).val();           
	// fields['token'] = 'tokens';
	// fields['order_id'] = 'key';                                 
// }); console.log(fields); 

/*https://www.monterail.com/blog/pwa-working-offline
https://www.monterail.com/blog/pwa-offline-dynamic-data*/