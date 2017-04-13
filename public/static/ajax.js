
function ajax(url, onSuccess, onError)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE )
        {
            if (xmlhttp.status == 200)
            {
                onSuccess(xmlhttp.responseText);
            }
            else
                onError();
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
