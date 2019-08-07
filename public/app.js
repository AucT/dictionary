window.addEventListener("load", function(){

    // Add a keyup event listener to our input element
    var search_input = document.getElementById('search_input');
    search_input.addEventListener("keyup", function(event){hinter(event)});

    // create one global XHR object
    // so we can abort old requests when a new one is make
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function hinter(event) {

    // retireve the input element
    var input = event.target;

    // retrieve the datalist element
    var search_list = document.getElementById('search_list');

    // minimum number of characters before we start to generate suggestions
    var min_characters = 2;

    if (input.value.length < min_characters ) {
        return;
    } else {

        // abort any pending requests
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                // We're expecting a json response so we convert it to an object
                var response = JSON.parse( this.responseText );

                // clear any previously loaded options in the datalist
                search_list.innerHTML = "";

                response.forEach(function(item) {
                    // Create a new <option> element.
                    var option = document.createElement('option');
                    option.value = item;

                    // attach the option to the datalist element
                    search_list.appendChild(option);
                });
            }
        };

        window.hinterXHR.open("GET", "/query.php?q=" + input.value, true);
        window.hinterXHR.send()
    }
}

function validateForm(){

    // Get the input element
    var input = document.getElementById('search_input');
    // Get the datalist
    var search_list = document.getElementById('search_list');


    // If we find the input inside our list, we submit the form
    for (var element of search_list.children) {
        if(element.value === input.value) {
            return true;
        }
    }

    // we send an error message
    alert("Такого слова нема в словнику");
    return false;
}