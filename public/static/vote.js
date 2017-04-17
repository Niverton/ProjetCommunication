
function upvote(button, id)
{
    ajax("/vote/upvote/" + id,
         function(response) {
             if (response === "true")
             {
                 button.innerText = DISABLED_UPVOTE;
                 button.disabled = true;

                 withLocalUpvotes( function(upvotes) {
                     upvotes[id] = true;
                 });
             }
         },
         function() {}
        );
}

function withLocalUpvotes(action)
{
    var upvotesStr = localStorage.getItem("upvotes");
    var upvotes = (upvotesStr === null) ? {} : JSON.parse(upvotesStr);
    action(upvotes);    
    localStorage.setItem("upvotes", JSON.stringify(upvotes));
}

function init()
{
    var buttons = document.getElementsByClassName("upvote button");
    for (var i = 0; i < buttons.length; i++)
        buttons[i].disabled = false;
    
    var lastSessionId = localStorage.getItem("sessionId");
    if (lastSessionId === null || Number( lastSessionId ) !== SESSION_ID)
    {        
        localStorage.setItem("upvotes", JSON.stringify( {} ));
        localStorage.setItem("sessionId", String(SESSION_ID));
    }
    else
    {
        withLocalUpvotes( function(upvotes) {
            Object.keys(upvotes).forEach( function(key,_) {
                var button = document.getElementById("upvote" + key);
                if (button !== null)
                {
                    button.innerText = DISABLED_UPVOTE;
                    button.disabled = true;
                }
            });
        });
    }
}


// function voteCounter(id){

//     if(localStorage[id]==1){
// 	clearLocalStorage();
// 	document.getElementById(id).disabled = true;
//    }else{

// 	if(typeof(Storage) !== "undefined") {
//             if (localStorage[id]) {
// 		localStorage[id] = Number(localStorage[id])+1;
//             }
// 	    else {
// 		localStorage[id] = 1;
//             } 
//         }else {
//             document.getElementById("votes").innerHTML = "localStorage n'est pas supporté";
//         }
// }
//     }



// function clearLocalStorage(){

// var values = new Array();
// var unJour = new Date();
// unJour.setHours(unJour.getHours() + 24); //temps dans le futur
// values.push(localStorage.clickcount);
// values.push(unJour);
// //Vérifier la date d'expiration
// if (values[0] < new Date()) {
//     localStorage.clear("votes");
// }
// }
