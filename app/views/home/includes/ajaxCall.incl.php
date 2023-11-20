<script type="text/javascript">
    function ajaxcall() {
        const ENV = <?php echo json_encode(defined('ENV') ? ENV : null); ?>;

        if (typeof ENV !== 'undefined') {
            const xhr = new XMLHttpRequest();
            const path = ENV === 'localhost' ? '/MVC/home/getTotalImages' : '/home/getTotalImages';

            xhr.open('GET', path, true);

            xhr.onload = function() {
                const serverResponse = document.getElementById("serverResponse");
                serverResponse.innerHTML = `The number of images currently in the gallery: ${this.responseText}`;
            };

            xhr.send();
        } else {
            console.error("ENV is not defined in JavaScript.");
        }
    }
</script>