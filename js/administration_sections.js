/* 
 * This code is used to change the sections dynamically by reading the anchor tag in the url.
 */
function getAnchor() {
	let currentUrl = document.URL,
	urlParts = currentUrl.split('#');

    return (urlParts.length > 1) ? urlParts[1] : null;
}

function selectSection() {
	let currentSection = getAnchor();
  	
  	// The list of available sections
  	const availableSections = ['produits', 'usagers', 'formules', 'statistiques'];

  	// Check if the anchor tag points to a valid section
  	if(!availableSections.includes(currentSection)) {
  		// If the anchor does not correspond to a section, display the default section
  		currentSection = 'default';
  	}

  	// Display the current section
	document.getElementById(currentSection).classList.remove('hidden');

	// Hide all the other sections
	let sections = document.getElementsByTagName('section');
	for(let i=0; i < sections.length; i++) {
		let section = sections[i];

		// We don't want to hide the selected section
		if(section.id != currentSection)
			section.classList.add('hidden');
	}
}

// Load the correct section when the DOM is loaded
document.addEventListener("DOMContentLoaded", selectSection);

// Change the section when the url changes
window.addEventListener("hashchange", selectSection);

