$(document).ready(() => {
	// Update the number of item in the cart
	updateCartItemCounter()
})

function cantLoadImg(img) {
	if($(img).next('.missing-img').length == 0) {
		$(img).after('<small class="missing-img text-danger">Impossible de charger l\'image.</small>')
	}

	$(img).attr('src', 'res/icon.svg')
}

function cancelOrder() {

	// Clear the session storage
	sessionStorage.clear();

	// Close the cart
	toggleShop()
}

function updateItemTotal() {
	let number = parseInt($('#item-details-quantity').text())
	let unitPrice = parseFloat($('#item-details-price').text())
	let totalPrice = unitPrice * number

	$('#item-details-total').text(totalPrice.toFixed(2))
}

function showItemDetails(id, name, price, imgSrc) {
	// Update the modal informations
	$('#item-details-name').text(name)
	$('#item-details-src').attr('src', 'res/images/products/' + imgSrc)
	$('#item-details-price').text(price.toFixed(2))
	$('#item-details-quantity').text(1)	// Reset the quantity to 1

	updateItemTotal()

	// Add events on buttons
	$('#item-details-add').click(function() {
		let number = parseInt($('#item-details-quantity').text())
		number++;
		$('#item-details-quantity').text(number)

		updateItemTotal()
	})

	$('#item-details-remove').click(function() {
		let number = parseInt($('#item-details-quantity').text())
		if(number > 1) number--;
		$('#item-details-quantity').text(number)

		updateItemTotal()
	})

	$('#item-details-submit').click(function() {
		let quantity = parseInt($('#item-details-quantity').text())
		addItemToCart(id, name, price, imgSrc, quantity)

		$('#item-details').modal('hide');

		// Remove the events
		$('#item-details-submit').off('click')
		$('#item-details-add').off('click')
		$('#item-details-remove').off('click')
	})

	// Show the modal
	$('#item-details').modal();
}

function addItemToCart(id, name, price, imgSrc, quantity) {
	console.log('Adding the product [' + id + '] ' + quantity + ' x ' + name + ', ' + price + '€ (' + imgSrc + ')');

	// Add it to the sessionStorage

	// Check if there is already an item with this id
	let item = sessionStorage.getItem(id)

	if(item == null) {
		// Create the new item
		let data = {
			"name" : name,
			"imgSrc": imgSrc,
			"price" : parseFloat(price, 2),
			"quantity" : parseInt(quantity),
			"id" : parseInt(id)
		}

		// Add to session storage
		sessionStorage.setItem(id, JSON.stringify(data))

	} else {
		// Update the quantity
		item = JSON.parse(item)
		item.quantity = parseInt(item.quantity) + parseInt(quantity)

		// Add it back to session storage
		sessionStorage.setItem(id, JSON.stringify(item))
	}

	// Update the cart product counter
	updateCartItemCounter();
}

function updateCartItemCounter() {
	let itemCount = 0

	// Calculate the item count
	for(let i=0; i < sessionStorage.length; i++) {
		let key = sessionStorage.key(i)
		let item = JSON.parse(sessionStorage.getItem(key))

		itemCount += item.quantity
  	}

	console.log('Count : ' + itemCount)

	if(itemCount === 0) {
		$('#cart-number-item').hide()
	} else {
		$('#cart-number-item').text(itemCount).show()
	}
}

function submitForm() {
	// Clear the session storage
	sessionStorage.clear();

	$('#order-summary-form').submit();
}

function toggleShop() {
	// Hide the item-details
	$('#item-details').modal('hide')

	let modal = $('#order-summary')
	let modalIcon = $('#cart-icon')
	let numberIcon = $('#cart-number-item')

	// Check if the modal is shown
	if(modal.hasClass('show')) {
		// Close the modal
		modal.modal('hide')

		// Replace the close icon with the cart
		modalIcon.removeClass('fa-times')
		modalIcon.addClass('fa-shopping-cart')

		updateCartItemCounter();

		// Hide the check button
		$('#check-icon').hide()

		// Clear the summary
		$('#order-summary-content').empty()

		return
	}

	// Add all items
	for(let i=0; i < sessionStorage.length; i++) {
		let key = sessionStorage.key(i)
		let item = JSON.parse(sessionStorage.getItem(key))

		addCartItem(item.id, item.name, item.quantity, item.price)
	}

  	// Set the total price
	let totalPrice = updateCartTotalPrice()

	// Set the icons
	modalIcon.removeClass('fa-shopping-cart')
	modalIcon.addClass('fa-times')
	numberIcon.hide()

	if(totalPrice > 0)
		$('#check-icon').show()
	else {
		$('#order-summary-content').append('<img class="img-fluid mx-auto d-block" src="res/empty-john-travolta.gif"><p class="text-center">Votre panier est vide !</p>')
	}

	// Show the cart
	$('#order-summary').modal('show')
}

function updateCartTotalPrice() {
	let totalPrice = 0
	
	// Add all items
	for(let i=0; i < sessionStorage.length; i++) {
  	let key = sessionStorage.key(i)
  	let item = JSON.parse(sessionStorage.getItem(key))

  	totalPrice += item.price * item.quantity
  }

  // Set the total price
	$('#order-summary-total').text(totalPrice.toFixed(2))

	return totalPrice
}

function removeItem(id) {
	$('#order-item-' + id).remove()
	sessionStorage.removeItem(id)

	updateCartTotalPrice()
	updateCartItemCounter()
}


function addCartItem(id, name, quantity, price) {


	let item = `
	<li id="order-item-` + id + `" class="list-group-item">
		<span class="badge badge-secondary badge-pill">` + quantity + `</span>
		<span class="ml-2">` + name + `</span>
		
		<span class="float-right ml-3 text-secondary clickable" onclick="removeItem(` + id + `)">x</span>
		<span class="float-right">` + (quantity * price).toFixed(2) + ` €</span>

		<input type="number" name="` + id + `" value="` + quantity + `" hidden>
	</li>
	`;

	$('#order-summary-content').append(item)
}