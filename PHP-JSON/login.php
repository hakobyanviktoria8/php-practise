<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="offset-3 col-9">
            <form action="loginProces.php" method="post" id="form" class="justify-content-center">
                <fieldset class="center">
                    <h1>Login Page</h1><br>
                    <div class="row">
                        <div class="col-2">E-mail:</div>
                        <div class="col-3"><input type="email" placeholder="E-mail" name="email" value="<?=$_SESSION['email']?>"></div>
                        <div class="col-3"><span class="error">*<?=$_SESSION['error']['email']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="col-2">Password:</div>
                        <div class="col-3"><input type="password" name="pass" placeholder="Password"></div>
                        <div class="col-3"><span class="error">*<?=$_SESSION['error']['pass']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="submit" value="Login" name="submit">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="offset-3 col-9">
            <img src="Images/christmas-border-images-free-download-1.png" style="height: 400px" alt="">
        </div>
    </div>
</div>

<?php include('footer.php'); ?>