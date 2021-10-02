/* 
 * This code is used to change the sections dynamically by reading the anchor tag in the url.
 */
function getAnchor() {
    let currentUrl = document.URL,
    urlParts = currentUrl.split('#');

    return (urlParts.length > 1) ? urlParts[1] : null;
}

function selectSection() {
    let currentAnchor = getAnchor();
    //console.log(currentAnchor);

    // Hide all sections that are not selected
    let sections = document.getElementsByClassName('linked-section');
    let hiddenSections = 0;

    for(let i=0; i < sections.length; i++) {
       let section = sections[i];

        // We don't want to hide the selected section
        if(section.id != currentAnchor) {
            hiddenSections++;
            section.style.display = 'none';
        } else {
           console.log(section);
        }
    }

    if(hiddenSections == sections.length) {
        // All sections have been hidden -> showing the default section
        document.getElementsByClassName('default-linked-section')[0].style.display = 'block';
    }
 }

// Load the correct section when the DOM is loaded
document.addEventListener("DOMContentLoaded", selectSection);

// Change the section when the url changes
window.addEventListener("hashchange", () => {
    // Show all sections first
    let sections = document.getElementsByClassName('linked-section');
    for(let i=0; i < sections.length; i++) {
        sections[i].style.display = 'block';
    }

    // The select the correct one not to hide
    selectSection();
});

