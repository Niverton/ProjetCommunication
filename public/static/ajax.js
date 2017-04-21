function ajax(url, onSuccess, onError)
{
    console.log("ajax(" + url + ")");
    
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE )
        {
            if (xmlhttp.status == 200)
            {
                console.log("ajax() : onSuccess(" + xmlhttp.responseText + ")");
                onSuccess(xmlhttp.responseText);
            }
            else
            {
                console.log("ajax() : onError");
                onError();
            }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function ajaxDemo()
{
    ajax("/",
         function(response) {
             console.log(response);
         },
         function() {
             console.log("ERROR");
         });
}
