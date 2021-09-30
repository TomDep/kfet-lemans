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
	var form = document.getElementById("order-form");
	var inputs = form.getElementsByTagName("input");

	var sum = 0;
	for(var i=0; i< inputs.length; i=i+2){
		var qty = inputs[i].value;
		var price = inputs[i+1].value;
	  sum += qty * price;
	}

	sum = sum.toFixed(2);
	document.getElementById("total").innerHTML = sum + "€";

	if(sum == 0){
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
		do{
			var x = document.getElementById("easter-egg");
			if(x != null){
				x.remove();
			}
		}while(x != null)
		
	}
}

function calculateTotalItems(){
	var form = document.getElementById("order-form");
	var inputs = form.getElementsByTagName("input");
	var num = 0;

	for(var i=0; i<inputs.length; i++){
		if(inputs[i].name != "price"){
			num += parseInt(inputs[i].value);
		}
	}

	var elmt = document.getElementById("number-item");

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

function toggleItem(categories, id){
	var x = document.getElementById("detailed-item");
	if(id==0 && categories==0){
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

		let myArray = Array.from(elmtList);
		//console.log(myArray);
		let idArray = findById(myArray, String(id));

		var img = myArray[idArray].firstElementChild.currentSrc;
		var name = myArray[idArray].children[1].children[0].textContent;
		var price = myArray[idArray].children[1].children[1].textContent;
		var priceFloat = price.match(/\d\W\S\d/g);
		priceFloat = parseFloat(priceFloat).toFixed(2);

		document.getElementById("item-picture").setAttribute("src",img);
		document.getElementById("item-name").innerHTML = name;
		document.getElementById("item-price").innerHTML = String(priceFloat);

		document.getElementById("btn-validate-lg").setAttribute("onclick","addItem(" + id + ")");

		quantityItem(0);

    x.style.display = "block";
    blur(1);
  } else {
    x.style.display = "none";
    blur(0);
  }
}

function toggleShop(){
	var x = document.getElementById("order-summary");
  if (x.style.display === "none" || x.style.display === "") {
    x.style.display = "block";
    toggleItem(0, 0);

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
  } else {
    x.style.display = "none";

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

function addItem(id){
	var presentation = document.createElement("div");
	presentation.classList.add("presentation-card");
	presentation.setAttribute("id",id);

	var img = document.createElement("img");
	img.classList.add("card-picture");

	var src = document.getElementById("item-picture").getAttribute("src");
	img.setAttribute("src",src);
	presentation.appendChild(img);

	var content = document.createElement("div");
	content.classList.add("content-sm");
	presentation.appendChild(content);

	var titre = document.createElement("h4");
	titre.classList.add("card-name");
	var title = document.getElementById("item-name").innerHTML;
	titre.innerHTML = title;
	content.appendChild(titre);

	var titre = document.createElement("h4");
	titre.classList.add("card-subtitles");
	var price = parseFloat(document.getElementById("item-price").innerHTML);
	price = price.toFixed(2);
	titre.innerHTML = "Prix unitaire: " + price + "€";
	content.appendChild(titre);

	var titre = document.createElement("h4");
	titre.classList.add("card-subtitles");
	var quantity = document.getElementById("item-quantity").innerHTML;
	titre.innerHTML = "Quantité: " + quantity;
	content.appendChild(titre);

	var input = document.createElement("input");
	input.setAttribute("type","number");
	input.setAttribute("name",id);
	input.setAttribute("value",quantity);
	input.setAttribute("hidden","");
	presentation.appendChild(input);

	var input = document.createElement("input");
	input.setAttribute("type","number");
	input.setAttribute("name","price");
	input.setAttribute("value",price);
	input.setAttribute("hidden","");
	presentation.appendChild(input);


	var close = document.createElement("div");
	close.classList.add("delete");
	var f = "deleteItem(" + id + ")";
	close.setAttribute("onclick",f);
	presentation.appendChild(close);

	var btn_del = document.createElement("i");
	btn_del.classList.add("fas");
	btn_del.classList.add("fa-times");
	close.appendChild(btn_del);

	

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