<script type="text/javascript">
    function ajaxcall() {

        var xhr = new XMLHttpRequest();
        <?php if (ENV === 'localhost') {
            echo "xhr.open('GET', '/MVC2/home/getTotalImages', true);";
        } else {
            echo "xhr.open('GET', '/home/getTotalImages', true);";
        } ?>

        xhr.onload = function() {
            const serverResponse = document.getElementById("serverResponse");
            serverResponse.innerHTML = "The number of images currently in the gallery: " + this.responseText;
        };

        xhr.send(null);
    }
</script>