document.getElementById("books").onclick = function() {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.status == 200) {
            document.getElementById("container").innerHTML = this.responseText;
            document.getElementById("title").innerHTML = "Browse books";

        }
    }
    xhttp.open("POST", "browse.php", true);
    xhttp.send();
}