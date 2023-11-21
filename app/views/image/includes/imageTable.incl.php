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
                <td> <?php e($user->username) ?> </td>
                <td> <?php e($user->email) ?> </td>
                <td><?php e("$user->street, $user->city") ?> </td>
                <td><?php e($user->imageName) ?> </td>
                <td><a target="_blank" href="<?= $user->path ?>">
                        <img style="width: 50px; height: 50x" src="<?= $user->path ?>" alt=""></a></td>
                <td>
                    <?php if ($_SESSION["userid"] == $user->imageUserId) : ?>
                        <form action="image/delete" method="POST">
                            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <input type="hidden" name="imageOwnerId" value="<?= $user->imageUserId ?>">
                            <input type="hidden" name="imageId" value="<?= $user->imageId ?>">
                            <input type="hidden" name="dirPath" value="<?= $user->dirPath ?>">
                            <button type="submit" class="btn btn-danger">Delete Image</button>
                        <?php endif ?>
                </td>
            </tr>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>