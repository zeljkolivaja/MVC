 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Upload image"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>



 <form action="<?= PROOT ?>image/insert" method="POST" enctype='multipart/form-data'>

   <div class="form-group">
     <label for="name">Name</label>
     <input type="text" required class="form-control" name="name" id="name">
   </div>


   <div class="form-group">
     <label for="exampleFormControlFile1">Select Image</label>
     <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
   </div>


   <button type="submit" class="btn btn-primary">Submit</button>

 </form>

 <table class="table">
   <thead class="thead-dark">
     <tr>
       <th scope="col">#</th>
       <th scope="col">User</th>
       <th scope="col">Email</th>
       <th scope="col">Adress</th>
       <th scope="col">Image</th>
       <th scope="col">Delete</th>
     </tr>
   </thead>
   <tbody>

     <?php
      foreach ($images as $user) : ?>
       <tr>

       <tr>
         <th scope="row">1</th>
         <td> <?=$user->username?> </td>
         <td> <?=$user->email?> </td>
         <td><?=$user->street . ", " . $user->city ?> </td>
         <td><?=$user->path?></td>
         <td>@mdo</td>
       </tr>

       </tr>
     <?php endforeach; ?>
   </tbody>
 </table>




 <?php $this->end(); ?>