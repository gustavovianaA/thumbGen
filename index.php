<form id="form" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault()">
<input type="file" name="fileUpload" id="fileUpload">
<input type="number" min="1" max="100" value="50" name="resizeValue" onchange="generateThumb()">
<!-- <button type="submit" onclick="generateThumb()">Send</button> -->
</form>
<article id="thumb"></article>	

<script>
function generateThumb(){
var xhttp = new XMLHttpRequest();
var form = document.getElementById('form');
data = new FormData(form);
xhttp.onreadystatechange = function() {
    if (xhttp.readyState == XMLHttpRequest.DONE) {
        var thumb = document.querySelector("#thumb");
        thumb.innerHTML = xhttp.responseText;
    }
}
xhttp.open("POST", "generateThumb.php");
xhttp.send(data);
}
</script>

