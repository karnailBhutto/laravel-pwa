function openIndexedDBDatabase() {	

	var URL=window.location.href;
	var arr=URL.split('/');//arr[0]='example.com //arr[1]='event'//arr[2]='14aD9Uxp?p=10'

	var parameter=arr[arr.length-1].split('?');//parameter[0]='14aD9Uxp' //parameter[1]='p=10
	var p_value=parameter[1].split('=')[1];//p_value='10';
	
	localforage.config({
		driver: localforage.INDEXEDDB,
	});
	
	var register = localforage.createInstance({
		name: "sfa-kh",
		storeName: "outlets"
	});
	
	var update = localforage.createInstance({
		name: "sfa-kh",
		storeName: "outlets-update"
	});
		
	var keyval = 'outlet_' + p_value; //alert(keyval);
	
	function padZerosToLength (value, minLength, padChar) {
		var iValLength= value.toString().length;
		return ((new Array((minLength + 1) - iValLength).join(padChar)) + value);
	}

	$(document).ready(function(e){ //alert('laluuuuu');
		register.getItem(keyval).then(function (value) {
			document.getElementById("outlet_id").value = padZerosToLength(value.outletid, 11, 0);
			document.getElementById("outlet_sname").value = value.outlet_sname;

			var type = document.getElementById("outlet_type");
			if(document.getElementById("outlet_type").value = value.outlet_type)
				{ 
					type.setAttribute("attribute", "selected"); 
					document.getElementById("select2-outlet_type-container").innerText = value.outlet_type;
					document.getElementById("select2-outlet_type-container").setAttribute('title',value.outlet_type);
				}
			
			document.getElementById("outlet_owner").value = value.outlet_owner;
			document.getElementById("outlet_contact").value = value.outlet_contact;
			
			var type = document.getElementById("outlet_region");
			if(document.getElementById("outlet_region").value = value.outlet_region)
				{ 
					type.setAttribute("attribute", "selected"); 
					document.getElementById("select2-outlet_region-container").innerText = value.outlet_region1; 
					document.getElementById("select2-outlet_region-container").setAttribute('title',value.outlet_region1);
				}
			
			if(document.getElementById("outlet_province").value = value.outlet_province)
				{ 
					type.setAttribute("attribute", "selected"); 
					document.getElementById("select2-outlet_province-container").innerText = value.outlet_province1; 
					document.getElementById("select2-outlet_province-container").setAttribute('title',value.outlet_province1);
				}
			
			if(document.getElementById("outlet_district").value = value.outlet_district)
				{ 
					type.setAttribute("attribute", "selected"); 
					document.getElementById("select2-outlet_district-container").innerText = value.outlet_district1; 
					document.getElementById("select2-outlet_district-container").setAttribute('title',value.outlet_district1);
				}
				
			document.getElementById("outlet_postal").value = value.outlet_postal;
			document.getElementById("outlet_address").value = value.outlet_address;

		}).catch(function(err) {
			console.error(err);
		});
	});
	
	$(document).on('click','#nextid',function(e){ //alert('lalu'); alert(p_value);
		e.preventDefault();

		var getOutletDetails = {
			outletid : p_value,
			outlet_id : padZerosToLength(p_value, 11, 0),
			token : document.getElementById("token1").value,
			outlet_sname : document.getElementById("outlet_sname").value,
			outlet_type : document.getElementById("outlet_type").value,
			outlet_owner : document.getElementById("outlet_owner").value,
			outlet_contact : document.getElementById("outlet_contact").value,
			outlet_region : document.getElementById("outlet_region").value,
			outlet_province : document.getElementById("outlet_province").value,
			outlet_district : document.getElementById("outlet_district").value,

			outlet_postal : document.getElementById("outlet_postal").value,
			outlet_address : document.getElementById("outlet_address").value,
			updated_by : document.getElementById("update").value,
			team : document.getElementById("team_id").value
		}

		update.setItem(keyval, getOutletDetails).then(function (value) {
		window.location = "https://sfa-staging.vindagroupsea.com/orders?id="+p_value;
		
		}).catch(function(err){
		  console.log(err);
		});

	});
	
	$(document).on('click','#submit',function(e){ 
		e.preventDefault();

		var getOutletDetails = {
			outletid : p_value,
			outlet_id : padZerosToLength(p_value, 11, 0),
			token : document.getElementById("token1").value,
			outlet_sname : document.getElementById("outlet_sname").value,
			outlet_type : document.getElementById("outlet_type").value,
			outlet_owner : document.getElementById("outlet_owner").value,
			outlet_contact : document.getElementById("outlet_contact").value,
			outlet_region : document.getElementById("outlet_region").value,
			outlet_region1 : document.getElementById("outlet_region").options[document.getElementById("outlet_region").selectedIndex].text,
			outlet_province : document.getElementById("outlet_province").value,
			outlet_province1 : document.getElementById("outlet_province").options[document.getElementById("outlet_province").selectedIndex].text,
			outlet_district : document.getElementById("outlet_district").value,
			outlet_district1 : document.getElementById("outlet_district").options[document.getElementById("outlet_district").selectedIndex].text,
			outlet_postal : document.getElementById("outlet_postal").value,
			outlet_address : document.getElementById("outlet_address").value,
			updated_by : document.getElementById("update").value,
			team : document.getElementById("team_id").value
		}
			
		register.setItem(keyval, getOutletDetails).then(function (val) {
		console.log(val.token);

		}).catch(function(err){
		  console.log(err);
		});

		update.setItem(keyval, getOutletDetails).then(function (vals) {
		console.log(vals.token);
		alert('Outlet details has been saved successfully');
		window.location = "https://sfa-staging.vindagroupsea.com/outlets?id="+p_value;

		}).catch(function(err){
		  console.log(err);
		});

	});
	
}

/*https://www.monterail.com/blog/pwa-working-offline
https://www.monterail.com/blog/pwa-offline-dynamic-data*/