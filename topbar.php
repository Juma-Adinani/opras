<?php
$sql = $con->query("SELECT firstname, surname, profile_photo FROM users, personal_details
            WHERE personal_details.user_id = users.id
            AND users.id = '" . $_SESSION['id'] . "'");
if(mysqli_num_rows($sql) == 1){
    $fetch = mysqli_fetch_assoc($sql);
}else{
    header("location:./personal-details.php");
}
?>
<div class="topbar">
    <nav class="navbar navbar-dark sticky-top bg-white flex-md-nowrap p-0 border-bottom shadow-lg" style="background: #f3f3f3; height: 13vh">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle" style="background: white; color: black">
                <i class="fa fa-bars text-dark"></i>
            </button>
            <div class="logo_section">
                <a href="./homepage.php"><img class="img-responsive" src="images/logo/mu_logo.png" alt="#" style="height: 4rem" /><strong class="h5"><span style="color: #fd876d">MU</span>&nbsp;<span class="text-secondary">-</span>&nbsp;<span class="text-black-50">OPRAS</span></strong></a>
            </div>
            <div class="right_topbar">
                <div class="icon_info">
                    <ul class="user_profile_dd">
                        <li class="bg-white">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                if ($fetch['profile_photo'] !== null) {
                                ?>
                                    <img class="img-responsive rounded-circle" src="images/profilePhotos/<?php echo $fetch['profile_photo']; ?>" alt="#" />
                                <?php
                                } else {
                                ?>
                                    <img class="img-responsive rounded-circle" src="images/profilePhotos/profile.jpg" alt="#" />
                                <?php
                                }
                                ?>
                                <span class="name_user text-muted"><?php echo $fetch['firstname'] . ' ' . $fetch['surname']; ?></span></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="profile.php">My Profile</a>
                                <a class="dropdown-item" href="settings.php">Settings</a>
                                <a class="dropdown-item" href="help.php">Help</a>
                                <a class="dropdown-item" href="./logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>