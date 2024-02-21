window.addEventListener(
	'load', () => {

		init()
		
		setInterval(() => {
			init()
		}, 60000)
	}
)

const getProduct = async () => {
	const loginID = 9

	if (loginID) {
		return $.ajax({
			type: "POST",
			url: "ajax/pos/getProducts.php",
			data: { 'zone_id': loginID },
			success: function (data) { },
			error: function (jqXHR, exception) { }
		})
	}
}

const init = () => {
	getProduct()
		.then(response => {
		
			const products = JSON.parse(response).GTS
			localStorage.products = JSON.stringify(products)

			let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()

			initCart(existingCart)
		})
		.catch(error => {
			console.log("fail")
		})
}

function add(product_id){
    
    let productList = localStorage.products ? JSON.parse(localStorage.products) : Array()
	let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()

	const product = productList.find(element => element.product_id == product_id)

	if (existingCart.find(element => element.product_id == product.product_id)) {
		for (let i = 0; i < existingCart.length; i++) {
			const currentProduct = existingCart[i]

			if (currentProduct.product_id == product.product_id) {
				if (existingCart[i].quantity < product.count) {
					existingCart[i].quantity += 1
				} else {
					alert('Maximum quantity reached')
				}
			}
		}
	} else {
		product.quantity = 1
		existingCart.push(product)
	}

	// removeCoupon()
	initCart(existingCart)
}

function clearCart(){
	if (confirm('Sure to clear cart')) {
		// removeCoupon()
		initCart(Array())
	}
}

function remove (product_id) {
	
	let productList = localStorage.products ? JSON.parse(localStorage.products) : Array()
	let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()

	const product = productList.find(element => element.product_id == product_id)

	let newCart = Array()

	for (let i = 0; i < existingCart.length; i++) {
		const currentProduct = existingCart[i]

		if (currentProduct.product_id == product.product_id) {
			if (currentProduct.quantity != 1) {
				currentProduct.quantity -= 1

				newCart.push(currentProduct)
			}
		} else {
			newCart.push(currentProduct)
		}
	}

	// removeCoupon()
	initCart(newCart)
}

function removeall(product_id){
	
	if (confirm('Sure to remove this product')) {
		let productList = localStorage.products ? JSON.parse(localStorage.products) : Array()
		let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()

		const product = productList.find(element => element.product_id == product_id)

		let newCart = Array()

		for (let i = 0; i < existingCart.length; i++) {
			const currentProduct = existingCart[i]

			if (currentProduct.product_id != product.product_id) {
				newCart.push(currentProduct)
			}
		}

		// removeCoupon()
		initCart(newCart)
	}
	
}

// const add = (product_id) => {
// 	let productList = localStorage.products ? JSON.parse(localStorage.products) : Array()
// 	let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()

// 	const product = productList.find(element => element.product_id == product_id)

// 	if (existingCart.find(element => element.product_id == product.product_id)) {
// 		for (let i = 0; i < existingCart.length; i++) {
// 			const currentProduct = existingCart[i]

// 			if (currentProduct.product_id == product.product_id) {
// 				if (existingCart[i].quantity < product.product_count) {
// 					existingCart[i].quantity += 1
// 				} else {
// 					notify('Maximum quantity reached', 0)
// 				}
// 			}
// 		}
// 	} else {
// 		product.quantity = 1

// 		existingCart.push(product)
// 	}

// 	removeCoupon()
// 	initCart(existingCart)
// }

const initCart = (existingCart) => {
	const cart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()
	// const deliveryCharge = localStorage.deliveryCharge ? parseInt(localStorage.deliveryCharge) : 0
	// const miscellaneousCharge = localStorage.miscellaneousCharge ? parseInt(localStorage.miscellaneousCharge) : 0

	// const loginId = document.getElementById('login_id').value

	if (existingCart != cart) {
		localStorage.cart = JSON.stringify(existingCart)

		const cartProducts = document.getElementById('cartProducts')
		cartProducts.innerHTML = ''

		if (existingCart.length) {
			for (const product of existingCart) {
				cartProducts.innerHTML += renderCart(product)
			}
			// document.getElementById('clearCart').style.display = 'block'
		} else {
			cartProducts.innerHTML = '<p class="text-center">Cart is empty</p>'
			// document.getElementById('clearCart').style.display = 'none'
		}
	}

	document.getElementById('totalitem').innerHTML = existingCart.length

	// const advanceCashChargeToggle = document.getElementById('advanceCashChargeToggle')
	// const advanceCashCharge = document.getElementById('advanceCashCharge')

	// const advanceCash = localStorage.advanceCash ? parseInt(localStorage.advanceCash) : 0

	// if (advanceCash) {
	// 	advanceCashChargeToggle.style.display = 'block'
	// 	advanceCashCharge.innerHTML = `- ₹ ${advanceCash}`
	// } else {
	// 	advanceCashChargeToggle.style.display = 'none'
	// 	advanceCashCharge.innerHTML = ``
	// }

	let subTotal = 0
	let gstSubTotal = 0
	// let waterSubTotal = 0
	// const couponCharge = localStorage.couponCharge ? localStorage.couponCharge : 0

	for (let i = 0; i < existingCart.length; i++) {
		const currentProduct = existingCart[i];

		subTotal += (currentProduct.quantity * currentProduct.price)

		gstSubTotal += (currentProduct.quantity * currentProduct.price)
	}

	let gstTotal;
	// let watergstTotal = parseInt((waterSubTotal * 5 / 100).toFixed())
	let othergstTotal = parseInt((gstSubTotal * 5 / 100).toFixed())
	// if(watergstTotal){
	// 	gstTotal = othergstTotal - watergstTotal
	// } else{
		gstTotal = othergstTotal
	// }

	// if (loginId == 86) {
	// 	gstTotal = parseInt(((gstSubTotal + deliveryCharge + miscellaneousCharge) * 5 / 100).toFixed())
	// }

	// let freeOfCost = document.getElementById('foc')

	// if (freeOfCost.checked) {
	// 	gstTotal = 0
	// }

	// const scrapSaleProductCheck = existingCart.some(product => {
	// 	return product.product_id == 55
	// })

	// if (scrapSaleProductCheck) gstTotal = 0

	// if (couponCharge) {
	// 	if (parseInt(couponCharge)) {
	// 		document.getElementById('couponChargeToggle').style.display = 'block'
	// 		document.getElementById('couponCharge').innerHTML = `- ₹ ${couponCharge}`
	// 	} else {
	// 		document.getElementById('couponChargeToggle').style.display = 'none'
	// 		document.getElementById('percentage').value = ''
	// 		document.getElementById('flat').value = ''
	// 	}
	// } else {
	// 	document.getElementById('couponChargeToggle').style.display = 'none'
	// 	document.getElementById('percentage').value = ''
	// 	document.getElementById('flat').value = ''
	// }

	document.getElementById('subTotal').innerHTML = `₹ ${subTotal}`
	document.getElementById('gstTotal').innerHTML = `₹ ${gstTotal}`

	document.getElementById('grandTotal').innerHTML = `₹ ${subTotal + gstTotal}`
	document.getElementById('grandTotal1').innerHTML = `₹ ${subTotal + gstTotal}`

	// if(document.getElementById('foc').checked) document.getElementById('grandTotal').innerHTML = `₹ 0`
}

const renderCart = (product) => {
	return `<ul class="product-lists">
			<li>
				<div class="productimg">
					<div class="productimgs">
						<img src="${product.productimage}" alt="img">
					</div>
					<div class="productcontet">
						<h4>${product.productname} </h4>
						<div class="productlinkset">
							<h5>${product.weight}</h5>
						</div>
						<div class="increment-decrement">
							<div class="input-groups">
								<input type="button" value="-" onclick="remove(${product.product_id})" class="button-minus dec button">
								<input type="text" name="child"  value="${product.quantity}" class="quantity-field">
								<input type="button" value="+" onclick="add(${product.product_id})"  class="button-plus inc button ">
							</div>
						</div>
					</div>
				</div>
			</li>
			<li>₹ ${product.price * product.quantity}.00</li>
			<li><a class="confirm-text" onclick="removeall(${product.product_id})"><img src="asset/img/icons/delete-2.svg" alt="img"></a></li>
			</ul>`
}


function validate() {
	if (confirm('Proceed to payment?')) {
		let existingCart = localStorage.cart ? JSON.parse(localStorage.cart) : Array()
		let productList = localStorage.products ? JSON.parse(localStorage.products) : Array()

		if (!existingCart.length) {
			alert('No products found in cart')
		} else {
			const name = document.getElementById('customername').value
			const email = document.getElementById('customeremail').value
			const phone = document.getElementById('custoemrphone').value
			// const razorpay_payment_url = document.getElementById('razorpay_url').value ? document.getElementById('razorpay_url').value : ''
			// const deliveryCharge = localStorage.deliveryCharge ? parseInt(localStorage.deliveryCharge) : 0
			// const miscellaneousCharge = localStorage.miscellaneousCharge ? parseInt(localStorage.miscellaneousCharge) : 0
			// const address = document.getElementById('address').value

			// if(!phone || !name || !address){
			if (!phone || !name ) {
				alert('Customer details required')
			} else {
				if (phone.length != 10) {
					alert('Invalid mobile number')
				} else {
					const ordertype = document.getElementById('ordertype').value
					const payment = document.getElementById('payment').value

					if (payment == 'default') {
						alert('Mode of payment required')
					} else {
						let subTotal = 0
						// let waterSubTotal = 0
						let productCheck = true

						for (let i = 0; i < existingCart.length; i++) {
							if (productCheck) {
								const currentProduct = existingCart[i];
								

								// if(currentProduct.product_id == 67){
								// 	waterSubTotal += (currentProduct.quantity * currentProduct.product_price)
								// }

								const checkingProduct = productList.find(product => product.product_id == currentProduct.product_id)
								if (checkingProduct.count < currentProduct.quantity) {
									productCheck = false
								} else {
									subTotal += (currentProduct.quantity * currentProduct.price)
								}
							}
						}

						// let watergstTotal = parseInt((waterSubTotal * 5 / 100).toFixed())

						if (!productCheck) {
							alert('Some of the cart products are out of stock')
						} else {
							// const couponCharge = localStorage.couponCharge ? localStorage.couponCharge : 0

							let gstTotal = parseInt((subTotal * 5 / 100).toFixed())

							// const loginID = document.getElementById('login_id').value
							// const zoneId = document.getElementById('zone').value // Select Zone In Institutional Hub Login

							// if (loginID == 86) {
							// 	gstTotal = parseInt(((subTotal + deliveryCharge + miscellaneousCharge) * 5 / 100).toFixed())
							// }

							// const advanceCash = document.getElementById('advanceCash')
							// const advanceCashValue = advanceCash.checked ? advanceCash.value : 0

							// let overall_gst;
							// if(watergstTotal){
							// 	overall_gst = gstTotal - watergstTotal;
							// }else{
								// overall_gst = gstTotal;
							// }

							// let freeOfCost = document.getElementById('foc')
							// let foc_checked = 0

							// if (freeOfCost.checked) {
							// 	// overall_total = 0
							// 	overall_gst = 0
							// 	foc_checked = 1
							// }

							let overall_total = subTotal + gstTotal

							const payload = {
								products: existingCart,
								user: {
									name,
									phone,
									email
								},
							
								orderType: ordertype,
								paymentMode: payment,
								gstTotal,
								sub_total: subTotal,
								overall_total,
							}
							localStorage.payload = JSON.stringify(payload)

							window.location.href = `pos-details.php`
						}
					}
				}
			}
		}
	}
}