function addItem(id, name, src, price, quantity) {
	//console.log('Adding the product [' + id + '] ' + quantity + ' x ' + name + ', ' + price + '€ (' + src + ')');

	// Add it to the sessionStorage

	// Check if there is already an item with this id
	let item = sessionStorage.getItem(id)

	if(item == null) {
		// Create the new item
		let data = {
			"name" : name,
			"src": src,
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

	// Update the quantity indicator on the shopping cart
	calculateTotalItems()

	debugSessionStorage()
}

function debugSessionStorage() {

	for(let i=0; i < sessionStorage.length; i++) {
		let key = sessionStorage.key(i)
		console.log(JSON.parse(sessionStorage.getItem(key)))
	}

}

function quantityItem(x){
	var qty = parseInt(document.getElementById("item-quantity").innerHTML);

	if(x==0){
		document.getElementById("item-quantity").innerHTML = "1";
	}else{
		qty += x;
		if(qty==0){
			qty = 1;
		}
		document.getElementById("item-quantity").innerHTML = String(qty);
	}
	calculateItemPrice();
}

function calculateItemPrice(){
	var qty = parseInt(document.getElementById("item-quantity").innerHTML);
	var price = parseFloat(document.getElementById("item-price").innerHTML);

	var totalPrice = qty * price;
	totalPrice = totalPrice.toFixed(2);

	document.getElementById("btn-validate-lg").value = "Ajouter pour " + totalPrice + "€";
}

function calculateTotalPrice(){
	
	let sum = 0

	// Get the total price from the articles stored in the session storage
	for(let i=0; i < sessionStorage.length; i++) {
		let key = sessionStorage.key(i)
		let item = JSON.parse(sessionStorage.getItem(key))
		sum += item.quantity * item.price
	}

	/*
	var form = document.getElementById("order-form");
	var inputs = form.getElementsByTagName("input");

	var sum = 0;
	for(var i=0; i< inputs.length; i=i+2){
		var qty = inputs[i].value;
		var price = inputs[i+1].value;
	  sum += qty * price;
	}
	*/

	sum = sum.toFixed(2);
	document.getElementById("total").innerHTML = sum + "€";

	if(sum == 0){
		// Display a message if the shopping cart is empty
		var x = document.createElement("div");

		x.style.backgroundImage = "url(res/empty-john-travolta.gif)";
		x.style.backgroundRepeat = "no-repeat";
		x.style.backgroundSize = "100% auto";
		x.style.marginTop = "80px";
		x.style.marginLeft = "40px";
		x.style.marginRight = "40px";
		x.style.width = "auto";
		x.style.height = "200px";
		x.setAttribute("id","easter-egg");

	  document.getElementById("order-form").appendChild(x);
	}else{
		// Remove any easter egg
		do{
			var x = document.getElementById("easter-egg");
			if(x != null){
				x.remove();
			}
		} while(x != null)
	}
}

/* Function that calculate the number of items in the shopping cart and update the indicator on top of the icon */
function calculateTotalItems(){

	let num = 0

	for(let i=0; i < sessionStorage.length; i++) {
		let key = sessionStorage.key(i)
		let item = JSON.parse(sessionStorage.getItem(key))
		let quantity = item.quantity
		num += quantity
	}

	var elmt = document.getElementById("number-item");
	if(elmt == null) return num

	if(num == 0){
		elmt.style.display = "none";
	}else{
		elmt.style.display = "block";
		elmt.innerHTML = num;
	}

	return num;
}

function findById(myArray, id) {
	for(let i=0; i<myArray.length;i++){
		if(myArray[i].className == "presentation-card"){
			if(myArray[i].id == id){
				return i;
			}
		}
	}
}

/* Function that creates/removes an interface to add the item to the shopping cart */
function toggleItem(categories, id) {
	var x = document.getElementById("detailed-item");
	if(id == 0 && categories == 0){
  	x.style.display = "none";
  	blur(0);
  	return;
  }

	if (x.style.display === "none" || x.style.display === "") {
		switch(categories){
			case 1: var elmtList = document.getElementById("hot-drinks").childNodes; break;
			case 2: var elmtList = document.getElementById("cold-drinks").childNodes; break;
			case 3: var elmtList = document.getElementById("snacks").childNodes; break;
			case 4: var elmtList = document.getElementById("formules").childNodes; break;
		}

		elmtList = Array.from(elmtList);
		let idArray = findById(elmtList, String(id));
		let element = elmtList[idArray];

		console.log(element);

		var img = element.firstElementChild.currentSrc;
		var name = element.children[1].children[0].textContent;
		var price = element.children[1].children[1].textContent;
		var priceFloat = price.match(/\d\W\S\d/g);
		priceFloat = parseFloat(priceFloat).toFixed(2);
		
		document.getElementById("item-picture").setAttribute("src",img);
		document.getElementById("item-name").innerHTML = name;
		document.getElementById("item-price").innerHTML = String(priceFloat);

		// Set the item quantity
		quantityItem(0); // In this case to 1


		// Add the onclick event
		document.getElementById("btn-validate-lg").addEventListener('click', function() {
			var quantity = $('#detailed-item .item-quantity').text().substring(10)
			console.log(quantity)

			addItem(id, name, img, priceFloat, quantity);

			// Close the interface
			toggleItem(0, 0)

			// Remove the event listener for this button so that the next time it wont add the item again
			document.getElementById("btn-validate-lg").removeEventListener('click', null)
		});

    x.style.display = "block";
    blur(1);
  } else {
    x.style.display = "none";
    blur(0);
  }
}

function toggleShop() {
	debugSessionStorage()

	var summaryOrder = document.getElementById("order-summary");
  
  // If the order summary is not displayde : display it
  if (summaryOrder.style.display === "none" || summaryOrder.style.display === "") {
    summaryOrder.style.display = "block";
    toggleItem(0, 0);

    // Empty the shoping summary
    $("#order-summary .presentation-card").remove()

    // Remove shopping cart and counter
    var shoppingCart = document.getElementById("shopping-cart");
    shoppingCart.remove();
    var counter = document.getElementById("number-item");
    counter.remove();

    // Replace by a time
    var icon = document.createElement("i");
    icon.classList.add("fas");
    icon.classList.add("fa-times");
    icon.setAttribute("id","icon-times");

    icon.style.fontSize = "40px";
    icon.style.marginLeft = "7px";
    icon.style.marginTop = "5px";

    var divIcon = document.getElementById("icon");
    divIcon.appendChild(icon);

    blur(1);
    // Add all product cards to the order summary

    for(let i=0; i < sessionStorage.length; i++) {
    	let key = sessionStorage.key(i)
    	let item = JSON.parse(sessionStorage.getItem(key))

    	addItemCard(item.id, item.name, item.src, item.price, item.quantity)
    }

  } else {
    summaryOrder.style.display = "none";

    // Remove time
    var times = document.getElementById("icon-times");
    times.remove();

    var shoppingCart = document.createElement("i");
    shoppingCart.classList.add("fas");
    shoppingCart.classList.add("fa-shopping-cart");
    shoppingCart.setAttribute("id", "shopping-cart");

    var counter = document.createElement("span");
    counter.classList.add("fa-layers-counter");
    counter.setAttribute("id", "number-item");

    var divIcon = document.getElementById("icon");
    divIcon.appendChild(shoppingCart);
    divIcon.appendChild(counter);

    blur(0);
    calculateTotalItems();
  }			
}

function addItemCard(id, name, src, price, quantity) {
	var presentation = document.createElement("div");
	presentation.classList.add("presentation-card");
	presentation.setAttribute("id",id);

	var img = document.createElement("img");
	img.classList.add("card-picture");
	img.setAttribute("src", src);
	presentation.appendChild(img);

	var content = document.createElement("div");
	content.classList.add("content-sm");
	presentation.appendChild(content);

	// Add product name
	var title = document.createElement("h4");
	title.classList.add("card-name");
	title.innerHTML = name;
	content.appendChild(title);

	// Add product price
	title = document.createElement("h4");
	title.classList.add("card-subtitles");
	title.innerHTML = "Prix unitaire: " + price + "€";
	content.appendChild(title);

	// Add product quantity
	title = document.createElement("h4");
	title.classList.add("card-subtitles");
	title.innerHTML = "Quantité: " + quantity;
	content.appendChild(title);

	// Create inputs for quantity and price
	var input = document.createElement("input");
	input.setAttribute("type","number");
	input.setAttribute("name", id);
	input.setAttribute("value", quantity);
	input.setAttribute("hidden","");
	presentation.appendChild(input);

	var input = document.createElement("input");
	input.setAttribute("type","number");
	input.setAttribute("name","price");
	input.setAttribute("value", price);
	input.setAttribute("hidden", "");
	presentation.appendChild(input);

	// Add the delete button
	var close = document.createElement("div");
	close.classList.add("delete");
	close.addEventListener('click', function() {
		deleteItem(id)
	})
	presentation.appendChild(close);

	var btn_del = document.createElement("i");
	btn_del.classList.add("fas");
	btn_del.classList.add("fa-times");
	close.appendChild(btn_del);

	// Append the card to the order summary
	document.getElementById("order-form").appendChild(presentation);

	calculateTotalItems();
	calculateTotalPrice();

	toggleItem(0,0);	
}

function deleteItem(id){
	var elmtList = document.getElementById("order-form").childNodes;
	let myArray = Array.from(elmtList);
	let idArray = findById(myArray, String(id));
	myArray[idArray].remove();

	// Remove the element from the session storage
	sessionStorage.removeItem(id)

	calculateTotalPrice();
	calculateTotalItems();
}


function blur(state){	
	// State 1 : blur the background and activate the overlay
	// State 0 : remove the overlay and blur effect	
	
	var containerElement = document.getElementById("container");		    
	var nav = document.getElementById("nav");

	if(state == 1){
    containerElement.setAttribute("class", "blur");

    // Fixing the margin problem with the navbar while applying a filter
    if(parseInt(nav.offsetHeight) == "60"){
    	nav.style.top = "-60px";
    }else{
      nav.style.top = "-100px";
    }
	} else{
    containerElement.setAttribute("class", null);
    nav.style.top = "0";
	}
}

calculateTotalItems();
calculateTotalPrice();