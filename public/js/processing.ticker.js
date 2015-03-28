//Ticker implemented as a Web Worker

function startTicker(msg) {
    var interval = msg.data.interval,
        tickUrl  = msg.data.url;

    setInterval(function () {

        xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                postMessage({xhr : {
                    readyState : xhr.readyState,
                    status : xhr.status,
                    responseText : xhr.responseText
                }});
            }
        };

        xhr.open("GET",tickUrl,true);
        xhr.setRequestHeader("Content-type","application/json");

        postMessage({xhr : {
            readyState : 1,
            status : undefined,
            responseText : undefined
        }});

        xhr.send();

    }, interval * 1000);
}

addEventListener ("message", startTicker, true);