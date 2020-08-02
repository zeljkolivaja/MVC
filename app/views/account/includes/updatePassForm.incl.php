<form action="<?=PROOT?>updatePass/updatePassword" method="POST">

    <div class="form-group">
        <label for="password">Old Password</label>
        <input type="password" required class="form-control" name="passwordOld" id="exampleInputPassword1">
    </div>

    <div class="form-group">
        <label for="passwordNew">New Password</label>
        <input type="password" required class="form-control" name="passwordNew" id="exampleInputPassword1">
    </div>

    <div class="form-group">
        <label for="passwordNew2">Enter New Password Again</label>
        <input type="password" required class="form-control" name="passwordNew2" id="exampleInputPassword1">
    </div>

    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">


    <button type="submit" class="btn btn-primary">Submit</button>

</form>