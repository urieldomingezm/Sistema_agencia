// Proxy para Google Ads
(function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1683982217981918", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var script = document.createElement("script");
            script.text = xhr.responseText;
            document.head.appendChild(script);
        }
    };
    xhr.send();
})();