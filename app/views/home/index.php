 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("page title"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>


 <p><span id="serverResponse"></span></p>
 <p> Click the button to see how many images there is currently in the database </p>



 <button type="button" class="btn btn-primary" onclick="setTimeout(ajaxcall, 1000)">Click me</button>

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

 <?php $this->end(); ?>