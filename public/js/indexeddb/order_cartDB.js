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
	
	var orderdetail = localforage.createInstance({
		name: "sfa-kh",
		storeName: "order_details"
	});
		
	var keyval = 'outlet_' + p_value; //alert(keyval);
	var key = 'order_' + p_value;
	
	var a = 1;
	function loop() {
	  if(a > 0){
		var keyor = a;
	  }
	  a++;
	  return keyor;
	}
	
	function padZerosToLength (value, minLength, padChar) {
		var iValLength= value.toString().length;
		return ((new Array((minLength + 1) - iValLength).join(padChar)) + value);
	}

	$(document).ready(function(e){ 
		register.getItem(keyval).then(function (value) {
			document.getElementById('outletid').innerHTML = 'Outlet ID :'+padZerosToLength(value.outletid, 11, 0);
			document.getElementById("outlet_sname").innerHTML = 'Outlet Name : '+value.outlet_sname;
			
			$("#order_empty").click(function myFunction() {
				// Get the checkbox
				var checkBox = document.getElementById("order_empty");
				if (checkBox.checked == true)
				{ 
					order.getItem(key).then(function (value) {  
					//e.preventDefault();
					
						var getOrder = {
							outlet_id : p_value,
							order_empty : 1,
							order_status : "",
							token : value.token,
							created_at : value.created_at
						}
						
						order.setItem(key,getOrder).then(function (val) {
							console.log(val); 
							alert('No order today for this store. You will redirect to search outlet.');
							window.location = "https://sfa-staging.vindagroupsea.com/search";
						})
					}).catch(function(err) {
						console.error(err);
					});						
				}
			});
			
			orderdetail.iterate(function(value, key, iterationNumber) {
				
			//console.log([key, value]); console.log(value.outlet_id);
			if(value.outlet_id == p_value) {   // Even if value is undefined, localforage returns null
				var appendTbl = "";        
				const ProductData = [value];
					 
				ProductData.forEach(function(product) {
					appendTbl += '<tr><td>'+product.category+'</td><td>'+product.description+'</td><td><a href="#" data-target="#deletefunc" data-toggle="modal" data-id="'+product.id+'" class="btn"><i class="fa fa-times-circle"></i></a></td><td id="loop"><input type="number" class="first" name="carton[]" min="1" placeholder="0" value="'+product.carton+'"></td><td id="loop1"><input type="number" class="second" name="packs[]" min="1" placeholder="0" value="'+product.pack+'"><input type="hidden" class="third" name="sku[]" value="'+product.sku+'"><input type="hidden" class="fourth" id="cate" name="category" value="'+product.category+'"><input type="hidden" class="fifth" name="desc" value="'+product.description+'"><input type="hidden" class="sixth" name="key" value="'+product.id+'"></td></tr>';
				});
				 
				$("#myTable").find('tbody').append(appendTbl);
				let tbl = document.querySelectorAll(".first"),
					sumVal = 0;
					
				let tbl1 = document.querySelectorAll(".second"),
					sumVal1 = 0;

				for (let i = 0; i < tbl.length; i++) {
				  sumVal += Number(tbl[i].value);
				}
				
				document.getElementById('tot1').innerHTML = sumVal;
				
				for (let i = 0; i < tbl1.length; i++) {
				  sumVal1 += Number(tbl1[i].value);
				}
				// console.log(sumVal);
				// console.log(sumVal1);
				document.getElementById('tot2').innerHTML = sumVal1;
				} 
			});
			
		}).catch(function(err) {
			console.error(err);
		});
	});
	
	$(document).on('click','#update',function(e) { 
		e.preventDefault();
		register.getItem(keyval).then(function (val) {  
			var tokens = val.token;
			var fields = $('.first').map(function() {
			  return {
				carton: $(this).val(),
				pack : $(".second",$(this).parent().parent()).val(),
				sku : $(".third",$(this).parent().parent()).val(),
				order_id : key,
				token : tokens,
				outlet_id : p_value,
				id : $(".sixth",$(this).parent().parent()).val(),
				description : $(".fifth",$(this).parent().parent()).val(),
				category : $(".fourth").val()
			  };
			}).get();
			
			//console.log(fields);
	
			for (var x in fields) { 
				//const obj = JSON.parse(fields[x]);
				orderdetail.setItem(fields[x].id, fields[x]).then(function (value) {
					//console.log(value);
				}).catch(function(err) {
					console.error(err);
				});
			}
			
			alert('Order line has been updated!');
			window.location = "https://sfa-staging.vindagroupsea.com/addnew?id="+p_value;
		});
	});
	
	
	$(document).on('click','#save',function(e) { 
		e.preventDefault();
		$('#notify1').hide();
		
		register.getItem(keyval).then(function (val) {  
			var tokens = val.token;
			
			function makeid(length) {
				var result           = 'P'+ p_value +'_';
				var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				var charactersLength = characters.length;
				for ( var i = 0; i < length; i++ ) {
				  result += characters.charAt(Math.floor(Math.random() * 
			 charactersLength));
			   }
			   return result;
			}
			
			var fields = $('.first').map(function() {
			  return {
				carton: $(this).val(),
				pack : $(".second",$(this).parent().parent()).val(),
				sku : $(".third",$(this).parent().parent()).val(),
				order_id : key,
				token : tokens,
				outlet_id : p_value,
				id : makeid(3),
				description : $(".fifth",$(this).parent().parent()).val(),
				category : $(".fourth").val()
			  };
			}).get();
			
			//console.log(fields);
	
			for (var x in fields) { 
				//const obj = JSON.parse(fields[x]);
				orderdetail.setItem(fields[x].id, fields[x]).then(function (value) {
					//console.log(value);
				}).catch(function(err) {
					console.error(err);
				});
			}
			
			$("#reload").load(" #reload > *");
			$("#reload1").load(" #reload1 > *");
			$("#reload2").load(" #reload2 > *");
			$('#slist').hide();
			$('#tunjuk').hide();
			$('#prod-list').empty();
			$('#notify1').show();
		});
	});
	
	
	
	$(document).on('click','#confirm',function(e){ //alert('lalu')
		e.preventDefault();
		
		order.getItem(key).then(function (value) {  
		e.preventDefault();
		
			var getOrder = {
				outlet_id : p_value,
				order_empty : value.order_empty,
				order_status : 1,
				token : value.token,
				created_at : value.created_at
			}
			
			order.setItem(key,getOrder).then(function (val) {
				//console.log(val); 
				alert('Order line has been confirmed!');
				window.location = "https://sfa-staging.vindagroupsea.com/search";
			})
		}).catch(function(err) {
			console.error(err);
		});
	});
	
	$(document).on('click','#tutup',function(e){ //alert('lalu')
		e.preventDefault();
		
		// order.getItem(key).then(function (value) {  
		// e.preventDefault();
		window.location = "https://sfa-staging.vindagroupsea.com/addnew?id="+p_value;
		// }).catch(function(err) {
			// console.error(err);
		// });
	});
	
	$(document).on('click','#close',function(e){ //alert('lalu')
		e.preventDefault();
		
		// order.getItem(key).then(function (value) {  
		// e.preventDefault();
		window.location = "https://sfa-staging.vindagroupsea.com/search";
		// }).catch(function(err) {
			// console.error(err);
		// });
	});
	
	$(document).on('click','#remove',function(e){ //alert('lalu')
		e.preventDefault();
		
		var key = document.getElementById("id1").value;
		orderdetail.removeItem(key).then(function (value) {  
		// e.preventDefault();
		window.location = "https://sfa-staging.vindagroupsea.com/addnew?id="+p_value;
		}).catch(function(err) {
			console.error(err);
		});
	});
}

/*https://www.monterail.com/blog/pwa-working-offline
https://www.monterail.com/blog/pwa-offline-dynamic-data*/
