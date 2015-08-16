/************************************************************************************************************************************
* Author : Tara Massey
* Date: 4/25/2015
* Class : CS290 Spring Term
* Overview : Uses asynchronous ajax calls to return gists from a user selected number of pages. Results are then filtered by language.
* Results are displayed with a button for moving the result from the result listing to the favorites section. The favorites section
* has a button to instantly remove the favorite selected. Favorites are in local storage and will show up until local storage is cleared.
*
* Citations : Citations are noted in the description of the function when appropriate. Sources included -
* Wolfred/Ghorashi/Instructor, Oregon State University CS290, Week Four, Video : More Local Storage
* Wolfred/Ghorashi/Instructor, Oregon State Univesity CS290, Week Four, Video : Ajax
* Mozilla Developer Network, "Ajax Getting Started", https://developer.mozilla.org/en-US/docs/AJAX/Getting_Started
* Beckett, Danny, Stack Overflow, "What is the difference between a synchronous and an asynchronous request? (async=true/false)"
* http://stackoverflow.com/questions/15379474/what-is-the-difference-between-a-synchronous-and-an-asynchronous-request-async
* Ghorashi, Soroush, Piazza, "Assignment 3 part 2 -pagination"
* Ghorashi, Sorough, Piazza, "Filtering by language"
* Ghorashi, Soroush, Piazza, "more instruction please!"
/************************************************************************************************************************************/

/* globals */
var gistList = new Array();
var settings = null;
var settingStr;
var favGistList = new Array();



/*********************************************************************************************************************
*                                   Function: startSearch()
* Function connected to the button onClick in HTML. Sends appropriate pages to the function that  makes AJAX calls
* one page at a time.
//********************************************************************************************************************/
function startSearch() {
    
    /* make sure the page number is valid and within range */
    var pages = getPageNumber();

    /* send 1 through user number of pages to AJAX function */
    for (var i = 1; i <= pages; i++) {
       search(i);          
    }
}




/*********************************************************************************************************
*                                   Function: search(i)
* Receives the page number from 1 to user specified amount.
* Makes the AJAX call
*
* This section outline based on:
* Wolfred/Ghorashi/Instructor, Oregon State Univesity CS290, Week Four, Video : Ajax
**********************************************************************************************************/
function search(i) {
        
        /* set it up */
        var url = "https://api.github.com/gists" + "?page=" + i + "&per_page=30";    

        /* Make request and catch errors */
        if (window.XMLHttpRequest) {                               // modern browsers
            httpReq = new XMLHttpRequest();
        }

        else {                                                      // IE6 & older, NULL
            alert("Error. Cannot create an instance.");
        }

        /* Make sure it's in a valid state and parse the response */
        httpReq.onreadystatechange = function () {
            if (httpReq.readyState == 4) {
               
                /* if valid, get info */
                var retParse = JSON.parse(this.responseText);

                /* send to be turned into Gists, filtered, and stored */
                generateGists(retParse);               
            }
        };

        httpReq.open("GET", url);
        httpReq.send();

}


/***********************************************************************************************
*                         Function: getPageNumber()
* Gets the user's page amount from HTML and error checks the value to make sure it's in an
* appropriate range. Error messages have been hit or miss when testing in Chrome, but work in
* all others.
*************************************************************************************************/
function getPageNumber() {

    /* get the user's selection */
    var page = document.getElementById("choices").value;

    /* error check range */
    if (page > 5) {
        window.alert("Please enter a number between 1 and 5");
        return;
    }

    if (page < 1) {
        window.alert("Please enter a number between 1 and 5");
        return;
    }

    if (!isNaN) {
        window.alert("Please enter a number. Really now...");
        return;
    }

    /* good to go! */
    else {
        return page;
    }
}




/***********************************************************************************************
*                        Function: getSelectLanguages()
* Gets the values from the language checkboxes in HTML. Stores any that are checked in an array.
* If no languages are seleced, per instructions, all languages will be selected.
***********************************************************************************************/
function getSelectLanguages() {
    var languages = new Array();
    var i = 0;

    /* store the languages that are checked */
    if (document.getElementById("python").checked == true) {
        languages[i] = "Python";
        i++;
    }

    if (document.getElementById("json").checked == true) {
        languages[i] = "JSON";
        i++;
    }

    if (document.getElementById("javascript").checked == true) {
        languages[i] = "JavaScript";
        i++;
    }

    if (document.getElementById("sql").checked == true) {
        languages[i] = "SQL";
        i++;
    }

    /* error catch for someone hitting submit w/out checking boxes */
    else if (i == 0) {
        languages[0] = "Python";
        languages[1] = "JSON";
        languages[2] = "JavaScript";
        languages[3] = "SQL";
    }

    /* send it back for comparison with user gist language */
    return languages;
}





/****************************************************************************************************
*                               Function: Gist(desc, url, id)
* create a new gist for storage
****************************************************************************************************/
function Gist(desc, url, id) {
    this.desc = desc;
    this.url = url;
    this.id = id;
}




/*****************************************************************************************************
*                           Function: generateGists(list)
* Loops through the gists returned from the AJAX call. Calls a filtering function on the returned gists
* to sort by language. Gists that pass the language filtering function are then turned into Gistss, and
* stored in an array.
*
* Method used for getting the returne gists language:
* Ghorashi, Sorough, Piazza, "Filtering by language"
******************************************************************************************************/
function generateGists(list) {
    var results = new Array();
    var valid = false;
    var i, url, desc, id;

/* FOR-IN loop for each listing provided by github, where url and desc is located */
    for (var i in list) {

        /* FOR-IN loop each file section in the listing, where language is located */
        for (var j in list[i].files) {

            /* get language listed under files, make sure it matchces user selection */
            valid = filter(list[i].files[j].language);

            /* if the language matches user selection, turn it into a gist*/
            if (valid == true) {
                url = list[i].html_url;
                id = list[i].id;
                if (list[i].description == null || list[i].description == " ") {
                    desc = "No Description Provided";
                }
                else {
                    desc = list[i].description;
                }

                /* add to the array for future access */
                gistList.push(new Gist(desc, url, id));
            }

          
        }

    }

    /* send the gists that passed filtering off to be shown in HTML */
    generateGistHtml(gistList);

}




/*****************************************************************************************************************
*                                   Function: filter(languageType)
* Receives the language type of the Gist returned from the AJAX call.
* Checks the language of the gist returned in the AJAX call against the array of allowable languages selected by
* the user
******************************************************************************************************************/
function filter(languageType) {

    /* new Arrays and boolean values for language checking */
    var langList = new Array();
    var amount = 0;
    var pLang;
    var jsLang;
    var javLang;
    var sLang;

    /* get the allowable languages */
    langList = getSelectLanguages();

    /* set variables to true if they're in the allowed language list */
    for(var i = 0; i < langList.length; i++){
        if(langList[i] == "Python"){
            pLang = true;
        }
        if(langList[i] == "JSON"){
            jsLang = true;
            console.log("I'm listing jsLang as TRUE");
        }
        if(langList[i] == "JavaScript"){
            javLang = true;
        }
        if(langList[i] == "SQL"){
            sLang = true;
        }
    }


    /* If the language of the result list matches the allowed languages, make valid*/
    if (languageType == "Python" && pLang == true) {
        return true;
    }
    if (languageType == "JSON" && jsLang == true) {
        return true;
    }
    if (languageType == "JavaScript" && javLang == true) {
        return true;
    }
    if (languageType == "SQL" && sLang == true) {
        return true;
    }
    else {
        return false;
    }
}





/*************************************************************************************************************
*                                Function: generateGistHtml(finalList)
* Receives filtered list of Gists that meet user search criteria.
*
* Checks the gist saved in the array against the id's of the gists in favorites. If the id's do not match,
* generates the HTML code for that gist and appends the new gist to the "results" div in the HTML code.
* Creates the code for the favorite button, which creates a new gist and sends it off to another function for
* storage in local storage.
*
* The name of this function, as well as the creation of the favorites button were heavily based off the
* instruction an psuedo-code from:
* Ghorashi, Sorough, Piazza, "more instruction please!"
*************************************************************************************************************/
function generateGistHtml(finalList) {

    var temp = new Array();

    /* see if it's in favorites */
    favGistList = JSON.parse(localStorage.getItem("userSettings"));
    for (var i = 0; i < finalList.length; i++) {
        for (var j = 0; j < favGistList.length; j++) {
            var ident = favGistList[j].id;
        }
        if (finalList[i].id != ident)
            temp.push(finalList[i]);
    }

    finalList.length = 0;
    for (var i = 0; i < temp.length; i++) {
        /* all Gists that are not in favorites go back in finalList */
        finalList[i] = temp[i];
    }

    /* set up the inner content to nothing */
    document.getElementById("results").innerHTML = "";

    /* Go through each object stored in filtered list */
    for (var i in finalList) {

        /* create the elements : a div, and an unordered list, an anchor the for url/desc, 
        and a list item to show the address. Per instructions, description doubles as link */
        var listings = document.createElement("div");
        var urlRow = document.createElement("ul");
        var text = document.createElement("li");
        var dtext = document.createElement("a");

        /* handle the favorite button that was the bane of my existance. Please see citation
        in function heading. */
        var fbutton = document.createElement("button");
        fbutton.innerHTML = "+";
        fbutton.setAttribute("gistId", finalList[i].id);
        fbutton.setAttribute("gistDesc", finalList[i].desc);
        fbutton.setAttribute("gistUrl", finalList[i].url);
        fbutton.onclick = function () {
            /* create the gist to be sent to favorites, with unique id */
            var gistId = this.getAttribute("gistId");                       
            var gistDesc = this.getAttribute("gistDesc");
            var gistUrl = this.getAttribute("gistUrl");
            var sendMe = new Gist(gistDesc, gistUrl, gistId);

            /* send the favorited Gists to be added to favorite array and local storage */
            addToFavs(sendMe);
        };

        /* put the data in the gist into a url and description */
        dtext.innerHTML = finalList[i].desc;
        dtext.href = finalList[i].url;

        /* add some website information so you can see the gist isn't a duplicate */
        text.innerHTML = finalList[i].url;

        /* append the text to the row and the div*/
        urlRow.appendChild(text);
        listings.appendChild(fbutton); 
        listings.appendChild(dtext);
        listings.appendChild(urlRow);

        /* then append the listings to the results div from html document */
        document.getElementById("results").appendChild(listings);  

        
    }

}



/****************************************************************************************************
*                       Function: window.onload 
* Creates favorite section from local storage on load.
* 
* Citation for this function:
* Wolfred/Ghorashi/Instructor, Oregon State Univesity CS290, Week Four, Video : More Local Storage
*****************************************************************************************************/
window.onload = function () {
    settingStr = localStorage.getItem("userSettings");

    /* I have no favorites in my local storage */
    if (settingStr === null) {
        settings = [];
        localStorage.setItem('userSettings', JSON.stringify(settings));
    }

    /* I have a history of favorites saved to local storage */
    else {
        settings = JSON.parse(localStorage.getItem("userSettings"));
        getFavs(); // go to the displaying favorite function so it can look pretty
    }
 
};


/****************************************************************************************************
*                       Function: getFavs()
* Displays the gists saved to local storage by generating HTML for those Gists, and appending the
* gists to the "favs" div in HTML.
* Basically a rewrite of the generateGistHtml() function. Button set up citation from 
* generateGistHtml() applies
*****************************************************************************************************/
function getFavs() {

    for (var i in settings) {

        /* create the elements : a div, and a ro the for url to be on seperately */
        var favorites = document.createElement("div");
        var favoriteRow = document.createElement("ul");
        var uftext = document.createElement("a");
        var dftext = document.createElement("li");

        /* deal with the remove button. Based on the layout provided for the favorites
        button in generateGistHtml(). Citation for favorites button applies. */
        var dbutton = document.createElement("button");
        dbutton.innerHTML = "Remove";
        dbutton.setAttribute("gistId", settings[i].id);
        dbutton.setAttribute("gistDesc", settings[i].desc);
        dbutton.setAttribute("gistUrl", settings[i].url);
        dbutton.onclick = function () {
            /* create the gist to be sent off for removal */
            var gistId = this.getAttribute("gistId");
            var gistDesc = this.getAttribute("gistDesc");
            var gistUrl = this.getAttribute("gistUrl");
            var sendMe = new Gist(gistDesc, gistUrl, gistId);
            removeItem(sendMe);

            /* update the gist HTML so it doesn't just add onto what's already there, like
            it did in testing, for forever */
            var list = document.getElementById("favs");
            while(list.hasChildNodes()) {
                 list.removeChild(list.firstChild);
            }
            /* refresh for immediate update */
            getFavs(); 
        };

        /* put the data in the gist into a url and description */
        dftext.innerHTML = settings[i].desc;
        uftext.innerHTML = settings[i].url;
        uftext.href = settings[i].url;

        /* append the text to the row and the div*/
        dftext.appendChild(dbutton);
        favoriteRow.appendChild(uftext);
        favorites.appendChild(dftext);

        /* then append the listings to the results div from html document, and the row for the url to the listing */
        favorites.appendChild(favoriteRow);
        document.getElementById("favs").appendChild(favorites);

   }
}



/*************************************************************************************************************
*                       Function: addToFavs(gist)
* Updates local storage to have the most recent favorite gist array. Makes sure the favorite gist array
* and what's in local storage are the same. Deletes the gist HTML from the list so we don't have a favorite gist
* in the search results
* This is likely inefficient, as I process an array each time a favorite is added, but I struggled terribly
* with adding just one Gist at a time and keeping the list fully updated.
**************************************************************************************************************/
function addToFavs(gist) {

  
        /* favGistList is likely outdated, update it with local storage items */
        favGistList = JSON.parse(localStorage.getItem("userSettings"));
    

    /* add the new Gist to your favorite list */
    favGistList.push(gist);

    /* clear local storage so you don't get the old list, plus this new array */
    localStorage.clear();

    /* update local storage to be the array with the newly added gist */
    localStorage.setItem("userSettings", JSON.stringify(favGistList));

    /* delete the favorites so we don't get a repeat of the same list plus one more value */    
    var list = document.getElementById("favs");
    while(list.hasChildNodes()) {
                 list.removeChild(list.firstChild);
    }

    /* update settings to be what's in local storage so favorites list can display properly, also
    updated list of favorites, cause this section has me paranoid */
   settings = JSON.parse(localStorage.getItem("userSettings"));
   favGistList = JSON.parse(localStorage.getItem("userSettings"));

   /* instantly reflect changes in the search results and the favorites list */
   generateGistHtml(gistList);
   getFavs();
}



/*****************************************************************************************************************
*                                    Function: removeItem(gist)
* Receives the gist to be removed.
* Removes an item from favorites. Updates local storage and favorites list.
*
* Citation: Idea of searching for a gist by ID is credited to Ghorashi, Soroush, Piazza, "more instruction please!"
******************************************************************************************************************/
function removeItem(gist){
    var temp = new Array();

    /* favGistList is likely outdated, so make sure it has what's in local storage */
    favGistList = JSON.parse(localStorage.getItem("userSettings"));

    /* if the Gist does NOT have the ID of the gist to be removed, store in a temp array */
    for(var i = 0; i < favGistList.length; i++){
        if(favGistList[i].id != gist.id)
            temp.push(favGistList[i]);
    }

    /* clear out local storage so we don't get an array stored after an array */
    localStorage.clear();

    /* set local storage to the temp array. This has every Gist that is NOT the one user wanted removed */
    localStorage.setItem("userSettings", JSON.stringify(temp));

    /* update settings so the getFavs() function can load properly */
    settings = JSON.parse(localStorage.getItem("userSettings"));

    /* update favGistList to reflect the removed Gist */
    favGistList = JSON.parse(localStorage.getItem("userSettings"));
}
