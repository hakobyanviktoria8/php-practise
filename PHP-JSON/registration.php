<?php include('header.php'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-9">
            <div class="offset-2">
                <h1>Registration Form</h1><br>
            </div>
            <form action="registrationProces.php" method="post" id="form" class="justify-content-center">
                <fieldset class="center">
                    <div class="row">
                        <div class="offset-2 col-lg-3">First Name:</div>
                        <div class="col-lg-3"><input type="text" name="fname" placeholder="First Name" value="<?=$_SESSION['fname']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['fname']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Last Name:</div>
                        <div class="col-lg-3"><input type="text" name="lname" placeholder="Last Name" value="<?=$_SESSION['lname']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['lname']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Address: </div>
                        <div class="col-lg-3"><input type="text" placeholder="Address" name="address" value="<?=$_SESSION['address']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['address']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Phone Number:</div>
                        <div class="col-lg-3"><input type="tel"  name="tel" placeholder="0XX-XX-XX-XX" value="<?=$_SESSION['tel']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['tel']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">E-mail:</div>
                        <div class="col-lg-3"><input type="email" placeholder="E-mail" name="email" value="<?=$_SESSION['email']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['email']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Gender:</div>
                        <div class="col-lg-3">
                            Male <input type="radio" name="gender" class="gender" value="male" <?php if (isset($_SESSION['gender']) && $_SESSION['gender']=="male") echo "checked";?>>
                            Female<input  class="gender" type="radio" name="gender" value="female" <?=$_SESSION['gender']=='female'?'checked':""?>></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['male']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Birthday:</div>
                        <div class="col-lg-3"><input type="date" name="bday" value="<?=$_SESSION['bday']?>"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['bday']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Password:</div>
                        <div class="col-lg-3"><input type="password" name="pass" placeholder="Password"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['pass']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-3">Repeat Password:</div>
                        <div class="col-lg-3"><input type="password" name="repass" placeholder="Repeat Password"></div>
                        <div class="col-lg-4"><span class="error">*<?=$_SESSION['error']['repass']?></span></div>
                    </div><br>
                    <div class="row">
                        <div class="offset-2 col-lg-6">
                            <input type="submit" value="Registration" name="submit">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-3"><img src="Images/1334625_thumb.png" alt="" style="height: 650px"></div>
    </div>
</div>

<?php include('footer.php'); ?>

