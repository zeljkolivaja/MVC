<form action="<?= PROOT ?>account/register" method="POST">

<div class="form-group">
    <label for="username">Username</label>
    <input type="text" value ='<?= $userData["username"] ?? ""?>' required class="form-control" name="username" id="username">
</div>

<div class="form-group">
    <label for="email">Email address</label>
    <input type="email" value ='<?= $userData["email"] ?? ""?>' required class="form-control" name="email" id="email" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" required class="form-control" name="password" id="exampleInputPassword1">
    <small id="passwordHelp" class="form-text text-muted">Password must be at least 8 characters long.</small>

</div>

<div class="form-group">
    <label for="password2">Enter password again</label>
    <input type="password" required class="form-control" name="password2" id="exampleInputPassword1">
</div>


<div class="form-group">
    <label for="city">City</label>
    <input type="text" value ='<?= $userData["city"] ?? ""?>' required class="form-control" name="city" id="city">
</div>


<div class="form-group">
    <label for="street">Street</label>
    <input type="text" value ='<?= $userData["street"] ?? ""?>' required class="form-control" name="street" id="street">
</div>

<button type="submit" class="btn btn-primary">Submit</button>

</form>
