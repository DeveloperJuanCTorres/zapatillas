function ipDetection() {

    var xhr = new XMLHttpRequest();
    var printElement = document.querySelectorAll('.js-ip-detection');
    
    xhr.onload = function () {
    
        if (xhr.status >= 200 && xhr.status < 300) {
    
            var rawObj = JSON.parse(xhr.responseText); 
            var ipCountryCode = rawObj.countryCode;
           // var ipCountryName = rawObj.country_name;
    
           printElement.forEach(function(elem) {
    
                   if (ipCountryCode != undefined) {
                    elem.setAttribute("data-isocountry", ipCountryCode);
                   }
                
    
                }
            );
        } else {
    
            console.log('Failed request');
        }
    
    };
    
    xhr.open('GET', 'https://extreme-ip-lookup.com/json/');
    //xhr.open('GET', 'https://freegeoip.app/json/');
    xhr.send();
    
    
    }
    
    ipDetection();     
    
    
    function toggleDropdown() {
    
        var dropdownContainer = document.querySelectorAll(".js-toggledropdown");    
        
    
        function showDropdown(dropdown, parent) {
            if (dropdown.classList.contains('dropdown-open')) {
                dropdown.style.display = 'none';
                dropdown.classList.remove('dropdown-open');
                parent.classList.remove('parent-dropdown-open');
                return;
            }
            else {
                dropdown.style.display = 'block';
                dropdown.className += ' dropdown-open';
                parent.className += ' parent-dropdown-open';
                return;
            }
        }
    
        function hideDropdown(dropdown, parent) {
            if (dropdown.classList.contains('dropdown-open')) {
                dropdown.style.display = 'none';
                dropdown.classList.remove('dropdown-open');
                parent.classList.remove('parent-dropdown-open');
                return;
            }
        }
    
        Array.prototype.forEach.call(dropdownContainer, function(element){
    
            var mainDropdown = element.parentNode.querySelector(".dropdown");
    
            document.addEventListener("click", function(event) {
        
                if ( !mainDropdown.contains(event.target) ) {
                    hideDropdown(mainDropdown, element);
                }
            });
        
            element.addEventListener("click", function(event) {
                showDropdown(mainDropdown, element);
                event.stopPropagation();
            });
    
            mainDropdown.querySelectorAll("li:not(.js-dropdown-element-blocked)").forEach(
                function(dropdownElement) {
                    dropdownElement.addEventListener("click", function() {
                        hideDropdown(mainDropdown, element);
                    });
                }
            );
        
        });
        
    }
    
    toggleDropdown();
    
    function filterResults() {
        // Declare variables
        var mainElement, input, filter, i, txtValue;
        mainElement = document.querySelectorAll('.js-filter-results');
    
        function typeSearch(input, clickElement) {
            filter = input.value.toUpperCase();
    
            for (i = 0; i < clickElement.length; i++) {
    
                txtValue = clickElement[i].textContent || clickElement[i].innerText;
                            
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                clickElement[i].style.display = "";
                } else {
                clickElement[i].style.display = "none";
                }
            }
        }
    
        mainElement.forEach(function(elem) {
    
                var input = elem.querySelector('.filter-results-input');
    
                var li = elem.querySelectorAll('li:not(.e-li-search)');
    
            
                input.addEventListener("keyup", function() {
                    typeSearch(input, li);
                });
    
            }
    
        );
    
      }
    
    filterResults();
    
    function selectCountryCode(preloadedLi, preloadedParent, preloadedInput) {
    
        const setCountryData = function setCountryData(li, parentElement, inputCountryCode) {
            let countryClasses = li.querySelector("span").getAttribute("class");
            let countryCode = li.querySelector("span").getAttribute("data-countrycode");
            let countryIsoCode = li.querySelector("span").getAttribute("data-isocountrycode");
            //var countryCodePlaceholder = li.querySelector("span").getAttribute("data-placeholder");
    
            parentElement.querySelector(".e-country-box i").className = countryClasses;
            parentElement.querySelector(".e-country-box .country-code").innerHTML = countryCode;
            inputCountryCode.value = countryCode;
            inputCountryCode.setAttribute("data-isocountrycode", countryIsoCode);
    
        }
    
        //Populate Fields dispatcher
    
        if (preloadedLi) {
    
            setCountryData(preloadedLi, preloadedParent, preloadedInput);
        }
    
    }
    
    //IP country observer update    
    let countryCodeSelector = document.querySelectorAll(".js-select-countrycode");
    
    countryCodeSelector.forEach(function(parentElement) {
    
        let observerOptions = { attributes: true, childList: true, characterData: true };
        const observerCallback = function(mutationsList, observer) {
    
            for(let mutation of mutationsList) {
                if (mutation.attributeName === 'data-isocountry') {
    
                    let ipDetectedCountry = parentElement.getAttribute("data-isocountry");
                    let inputCountryCode = parentElement.querySelector(".e-input-phone-country-code");
    
                    observer.disconnect();
    
                    if (parentElement.querySelector("span[data-isocountrycode='"+ ipDetectedCountry +"']") != null) {
                        var isoCountry = parentElement.querySelector("span[data-isocountrycode='"+ ipDetectedCountry +"']").closest("li");
                    
                        selectCountryCode(isoCountry, parentElement, inputCountryCode);    
                    } 
    
                }
            }
        };
    
        let observer = new MutationObserver(observerCallback);
        observer.observe(parentElement, observerOptions);
        
        // Select code from dropdown
    
        let inputCountryCode = parentElement.querySelector(".e-input-phone-country-code");
        let countryCodes = parentElement.querySelectorAll("li:not(.js-dropdown-element-blocked)");
    
        countryCodes.forEach(
           function(li) {
       
               li.addEventListener("click", function() {
                   selectCountryCode(li, parentElement, inputCountryCode);
               });
           }
        ); 
    
    });