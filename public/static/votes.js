function voteCounter(id){

    if(localStorage[id]==1){
	clearLocalStorage();
	document.getElementById(id).disabled = true;
   }else{

	if(typeof(Storage) !== "undefined") {
            if (localStorage[id]) {
		localStorage[id] = Number(localStorage[id])+1;
            }
	    else {
		localStorage[id] = 1;
            } 
        }else {
            document.getElementById("votes").innerHTML = "localStorage n'est pas supporté";
        }
}
    }



function clearLocalStorage(){

var values = new Array();
var unJour = new Date();
unJour.setHours(unJour.getHours() + 24); //temps dans le futur
values.push(localStorage.clickcount);
values.push(unJour);
document.getElementById("votes").innerHTML = "date expiration " + values[1];
//Vérifier la date d'expiration
if (values[0] < new Date()) {
    localStorage.clear("votes");
}
}
