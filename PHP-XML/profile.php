<?php
include('header.php');
include('functions.php');
$user_id = $_SESSION["user_id"];
$user = get_user_by_attr("id", $user_id);   //կանչում է Ֆունլկցիան id ստւգելու համար
$avatarElements = $user->getElementsByTagName("avatar");    //ստանալ բոլոր avatar-ները
$avatar = null;
if ($avatarElements->length != 0) {
    $avatar = $avatarElements->item(0)->nodeValue;
    $_SESSION['avatar'] = $avatar;
}
?>
<div class="container mt-4">
    <div class="row">
        <div class="offset-2 col-4">
            <div class="prof_img">
                <?php
                if($avatar == null){                                   //եթե avatar չկա դրած profile-ի նկարը կլինի
                    echo "<img src='Images/avatars/boy1%20.png' class='profile_img'>";
                } else {
                    echo "<img src='Images/avatars/$avatar' class='profile_img'>";
                }
                if (isset($avatar)){?>
                    <a href="deleteImg.php" class="btn btn-danger" style="position: absolute; top: 5px; right: 30px;">
                        <i class="fas fa-trash-alt"></i>
                    </a>
              <?php  } ?>
            </div>
            <form action="profileImg.php" method="post" enctype="multipart/form-data">
                <label class="btn btn-primary" style="position: absolute; bottom: 45px; right: 170px">
                    <i class="fas fa-camera-retro"></i>
                    <input type="file" name="image" style="display:none">
                </label>
                <input type="submit" name="submit" value="Upload" class="mt-2">
            </form>
        </div>
        <div class="col-4">
            <?php
            echo "<h2>About Me</h2> <br>";
            echo "Name: ".$user->getElementsByTagName("fname")->item(0)->nodeValue." ".$user->getElementsByTagName("lname")->item(0)->nodeValue."<br>";
            echo "Address: ".$user->getElementsByTagName("address")->item(0)->nodeValue."<br>";
            echo "Phone Number: ".$user->getElementsByTagName("tel")->item(0)->nodeValue."<br>";
            echo "E-mail: ".$user->getAttribute("email")."<br>";
            echo "Birthday: ".$user->getElementsByTagName("bday")->item(0)->nodeValue."<br>";
            echo "Address: ".$user->getElementsByTagName("address")->item(0)->nodeValue;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center my-3">My Photos</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <form action="galleryCreate.php" method="post" enctype="multipart/form-data">
                <label class="btn btn-primary mt-5 mx-5"><i class="fas fa-camera-retro"  style="width: 20px; height: 20px" ></i>
                    <input type="file" name="image"  style="display:none">
                </label>
                <input type="submit" name="submit" value="upload">
            </form>
        </div>
        <div class="col-10">
          <div class="row">
            <?php
            $doc = new DOMDocument('1.0');           //ստեղծումա DOM obekt,որը պարունակում է xml-ը
            $xmlFile = "db/gallery.xml";            //XML-ի ճանապարհը
            $doc->load($xmlFile);
            //Fetch user galleries
            $galleries = $doc->getElementsByTagName("gallery");
            $userGalleries = [];
            foreach ($galleries as $gallery) {
                if ($gallery->getAttribute("user_id") == $user_id) {
                    array_push($userGalleries, $gallery);
                }
            }
            $galleryCount = count($userGalleries);
            $limit = 3;
            $page_count = ceil($galleryCount/$limit);
            if(isset($_GET['page_id'])){
                $page_id = $_GET['page_id'];
            } else {
               $page_id = 1;
            }
            $offset = ($page_id - 1) * $limit;
            for ($i = $offset; $i < $offset + $limit && $i < count($userGalleries); $i++) {
            ?>
            <div class="col-4">
                <img src="Images/gallery/<?=$userGalleries[$i]->getElementsByTagName("img")->item(0)->nodeValue?>" alt="" width="100%" height="190">
                <a href="galleryDelete.php?gallery_id=<?=$userGalleries[$i]->getAttribute('id')?>" class="btn btn-danger" style="position: absolute; top: 5px; right: 20px" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="galleryProfile.php?gallery_id=<?=$userGalleries[$i]->getAttribute('id')?>" class="btn btn-info" style="position: absolute; bottom: 5px;right: 135px" title="Add profile">
                    <i class="far fa-id-card"></i>
                </a>
            </div>
            <?php }?>
          </div>
        </div>
    </div>
    <div class="pagination justify-content-center h4 mt-3">
        <?php
        for($i = 1; $i <= $page_count; $i++){
            if ($page_id == $i){
                echo  "<span class='bg-primary text-white p-2'>".$i."</span>";
            } else {
                echo "<a class='p-2 bg-light' href='profile.php?page_id=$i'> $i</a>";
            }
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>


