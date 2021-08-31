	
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


function kirimData(outlets)
{   //console.log(outlets);
	
    console.log('processing outlet ' + outlets.outletid);	
	
    fetch('outlet-sync',{
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
			'X-CSRF-TOKEN': outlets.token
        },
        body: JSON.stringify({
			outletid : outlets.outletid,
			outlet_sname : outlets.outlet_sname,
			outlet_type : outlets.outlet_type,
			outlet_owner : outlets.outlet_owner,
			outlet_contact : outlets.outlet_contact,
			outlet_region : outlets.outlet_region,
			outlet_province : outlets.outlet_province,
			outlet_district : outlets.outlet_district,
			outlet_postal : outlets.outlet_postal,
			outlet_address : outlets.outlet_address,
			updated_by : outlets.updated_by,
			team_id : outlets.team
        })
    }) 
    .then(function(response){ //console.log(response);
        response.text().then(function(text){ //console.log(text);
            if (text == "success")
            {  
                console.log('deleting outlet_'+outlets.outletid);
                register.removeItem('outlet_'+outlets.outletid)
            }
        });
    }).catch(function(err)
    {
        console.log("error " + err);
    });
};

function insertData(orders)
{   //console.log(outlets);
	
    console.log('processing order ' + orders.outlet_id);	
	
    fetch('order-sync',{
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
			'X-CSRF-TOKEN': orders.token
        },
        body: JSON.stringify({
			outlet_id : orders.outlet_id,
			order_empty : orders.order_empty,
			order_status : orders.order_status,
			created_at : orders.created_at
        })
    }) 
    .then(function(response){ //console.log(response);
        response.text().then(function(text){ //console.log(text);
            if (text == "success")
            {  
                console.log('deleting order_'+orders.outlet_id);
                order.removeItem('order_'+orders.outlet_id)
            }
        });
    }).catch(function(err)
    {
        console.log("error " + err);
    });
};
	
function masukData(orderdetails)
{   //console.log(orderdetails);
	
    console.log('processing details' + orderdetails.order_id);	

    fetch('detail-sync',{
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
			'X-CSRF-TOKEN': orderdetails.token
        },
        body: JSON.stringify({
			order_id : orderdetails.order_id,
			cartons : orderdetails.carton,
			packs : orderdetails.pack,
			sku : orderdetails.sku,
			outlet_id : orderdetails.outlet_id
        })
    }) 
    .then(function(response){ //console.log(response);
        response.text().then(function(text){ //console.log(text);
            if (text == "success")
            {  
                console.log('deleting orderdetails '+orderdetails.id);
                orderdetail.removeItem(orderdetails.id)
            }
        });
    }).catch(function(err)
    {
        console.log("error " + err);
    });
	
};


