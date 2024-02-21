window.addEventListener(
	'load',
	() => {
		const payload = localStorage.payload ? JSON.parse(localStorage.payload) : null
        // alert(payload)

		// if (!payload) window.location.href = 'posdashboard.php'

		// document.getElementById('inputTag').focus()
		renderItems(payload.products)

		document.getElementById('userName').innerHTML = `${payload.user.name}`
		document.getElementById('userEmail').innerHTML = `${payload.user.email}`
		document.getElementById('userPhone').innerHTML = `+91${payload.user.phone}`
		document.getElementById('gstCharge').innerHTML = `₹ ${payload.gstTotal}`
		// document.getElementById('deliveryCharge').innerHTML = `₹ ${payload.deliveryCharge}`
		document.getElementById('subTotal').innerHTML = `₹ ${payload.sub_total}`
		document.getElementById('overallTotal').innerHTML = payload.overall_total
		
		// if(parseInt(payload.miscellaneousCharge)){
		// 	document.getElementById('miscellaneousToggle').style.display = 'block'
		// 	document.getElementById('miscellaneousCharge').innerHTML = `₹ ${payload.miscellaneousCharge}`
		// }

		// if(parseInt(payload.couponCharge)){
		// 	document.getElementById('couponToggler').style.display = 'block'
		// 	document.getElementById('coupon').innerHTML = `₹ ${payload.couponCharge}`
		// }

		// if(parseInt(payload.foc_checked)){
		// 	document.getElementById('focToggler').style.display = 'block'
		// 	document.getElementById('foc').innerHTML = ` - ₹ ${payload.overall_total}`
		// 	document.getElementById('overallTotal').innerHTML = 0
		// }

		// if(parseInt(payload.advancePayment)){
		// 	document.getElementById('advanceCashToggler').style.display = 'block'
		// 	document.getElementById('advanceCash').innerHTML = `- ₹ ${parseInt(localStorage.advanceCash)}`
		// }

		// const inputTag = document.getElementById('inputTag')
		// if(parseInt(payload.paymentMode)){
			if(parseInt(payload.paymentMode) == 1){
				document.getElementById('paymentMode').innerHTML = 'case'
			} else if(parseInt(payload.paymentMode) == 2){
				document.getElementById('paymentMode').innerHTML = 'UPI'
			} else if(parseInt(payload.paymentMode) == 3){
				document.getElementById('paymentMode').innerHTML = 'Razorpay'
			}else{
				document.getElementById('paymentMode').innerHTML = 'Account'
			}

		// 	document.getElementById('inputToggle').style.display = 'none'
		// } else{
		// 	document.getElementById('paymentMode').innerHTML = 'Cash'
		// 	document.getElementById('inputTitle').innerHTML = 'Received Amount'
		// 	document.getElementById('balanceToggle').style.display = 'block'

		// 	inputTag.placeholder = 'Received Amount'
		// 	inputTag.type = 'number'
		// 	inputTag.onkeyup = function() { converter(this.value) }
		// }

		// if(parseInt(payload.orderType)){
			if(parseInt(payload.orderType) == 1){
				document.getElementById('orderType').innerHTML = 'Walk In'
			} else{
				document.getElementById('orderType').innerHTML = 'Delivery'
			}
		// } else{
		// 	document.getElementById('orderType').innerHTML = 'Walk In'
		// }
	}
)

const renderItems = (products) => {
	const renderProducts = document.getElementById('finalcartProducts')
	renderProducts.innerHTML = ''

	for (const product of products) {
        // alert(product.productname)
		renderProducts.innerHTML += `
			<div class="col-sm-8">
					<p class="text-black">${product.productname}</p>
			</div>
			<div class="col-sm-4">
					<p class="float-right text-black">${product.quantity} X ${product.price}</p>
			</div>
		`
	}
}