<h1>Login</h1>
<div class="row align-items-center g-lg-5 py-5">
    <div class="col-md-12 mx-auto col-lg-12">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="../index.php?page=register_submit" method="post">
            <div class="form-floating mb-3">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input name="repeat_password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Repeat password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        </form>
    </div>
</div>