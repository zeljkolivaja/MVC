<script type="text/javascript">
function ajaxcall() {

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/MVC2/home/getTotalImages', true);

    xhr.onload = function() {
        const serverResponse = document.getElementById("serverResponse");
        serverResponse.innerHTML = "The number of images currently in the gallery: " + this.responseText;
    };

    xhr.send(null);
}
</script>