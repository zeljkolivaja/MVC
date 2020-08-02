<form action="<?=PROOT?>login/login" method="POST">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" value='<?php e($email) ?? ""?>' required class="form-control" name="email" id="email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" required class="form-control" name="password" id="exampleInputPassword1">
    </div>

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="rememberme">
        <label class="form-check-label" for="rememberme">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>