 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Upload image"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div class="text-center"><h1>IMAGE UPLOAD</h1></div>

 <form action="<?= PROOT ?>image/insert" method="POST" enctype='multipart/form-data'>

   <div class="form-group">
     <label for="name">Image Name</label>
     <input type="text" required class="form-control" name="name" id="name">
   </div>


   <div class="form-group">
     <label for="exampleFormControlFile1">Select Image</label>
     <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
   </div>


   <button type="submit" class="btn btn-primary">Submit</button>
   <input type="hidden" name="image_id" value="$user->" id="name">

 </form>

 <hr>


<br/>
<div class="text-center"><h1>IMAGE GALLLERY</h1></div>
 <table class="table">
   <thead class="thead-dark">
     <tr>
       <th scope="col">#</th>
       <th scope="col">User</th>
       <th scope="col">Email</th>
       <th scope="col">Adress</th>
       <th scope="col">Image name</th>
       <th scope="col">Image</th>
       <th scope="col">Delete</th>
     </tr>
   </thead>
   <tbody>

     <?php $counter = 1;
      foreach ($images as $user) : ?>
       <tr>

       <tr>
         <th scope="row"><?= $counter++ ?> </th>
         <td> <?= $user->username ?> </td>
         <td> <?= $user->email ?> </td>
         <td><?= $user->street . ", " . $user->city ?> </td>
         <td><?= $user->name ?> </td>
         <td><a target="_blank" href="<?= PROOT . $user->path ?>">
             <img style="width: 50px; height: 50x" src="<?= PROOT . $user->path ?>" alt=""></a></td>
         <td>
         <?php if ($_SESSION["userid"] == $user->imageUserId): ?>
           <form action="image/delete" method="POST">
             <input type="hidden" name="imageOwnerId" value="<?= $user->imageUserId ?>">
             <input type="hidden" name="imageId" value="<?= $user->imageId ?>">
             <input type="hidden" name="path" value="<?=$user->path ?>">
             <button type="submit" class="btn btn-danger">Delete Image</button>
             <?php endif ?>
         </td>
       </tr>

       </tr>
     <?php endforeach; ?>
   </tbody>
 </table>




 <?php $this->end(); ?>