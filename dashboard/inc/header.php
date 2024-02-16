<?php

    include("inc/dbconn.php");
    $user=$_SESSION["username"];

    $shead = "SELECT * FROM login WHERE username='$user'";
    $resulthead = $conn->query($shead);
    $rhead = $resulthead->fetch_assoc();

    $headid = $rhead["id"];

    $headname = "";

    if($rhead["id"] == "1" || $rhead["control"] == 1)
    {
        $headname = "Admin";
    }
    else
    {
        $idhead = $rhead["id"];
        if($rhead["control"] == 2)
        {
            $shead1 = "SELECT * FROM hotel WHERE lid='$idhead'";
            $resulthead1 = $conn->query($shead1);
            $rhead1 = $resulthead1->fetch_assoc();

            $headname = $rhead1["name"];
        }
        else
        {
            if($rhead["control"] == 3)
            {
                $shead1 = "SELECT * FROM worker WHERE lid='$idhead'";
                $resulthead1 = $conn->query($shead1);
                $rhead1 = $resulthead1->fetch_assoc();

                $headname = $rhead1["name"];
            }
        }
    }

?>
<header class="ttr-header">
    <div class="ttr-header-wrapper">
        <!--sidebar menu toggler start -->
        <div class="ttr-toggle-sidebar ttr-material-button">
            <i class="ti-close ttr-close-icon"></i>
            <i class="ti-menu ttr-open-icon"></i>
        </div>
        <!--sidebar menu toggler end -->
        <div class="row">
            <div style="width: 16.66% !important">
                <div class="ttr-logo-box">
                    <div>
                        <a href="index.php" class="ttr-logo">
                            <img class="ttr-logo-mobile" alt="" src="assets/images/logo.png" >
                            <img class="ttr-logo-desktop" alt="" src="assets/images/logo.png" >
                        </a>
                    </div>
                </div>
            </div>
            <div style="width: 83.33% !important">
                <div class="ttr-header-right">
                    <ul class="ttr-header-navigation">
                        <audio id="audio" src="assets/audio/ring.mp3"></audio>
                        <li>
                            <a href="#" class="ttr-material-button ttr-submenu-toggle">
                                <i class="fa fa-bell"></i>
                                <span id="counter" style="position: absolute;left: 22px;top: 15px;background: red;" class="badge badge-info badge-counter"></span>
                            </a>
                            <div class="ttr-header-submenu noti-menu">
                                <div class="ttr-notify-header">
                                    <span class="ttr-notify-text">User Notifications</span>
                                </div>
                                <div class="noti-box-list" id="order-notification" style="overflow: scroll !important; max-height: 500px">
                                    
                                </div>
                            </div>
                        </li>
                        <?php
                            if($rhead["control"] != 3)
                            {
                        ?>
                                <li>
                                    <label style="margin-top:12px;margin-right: 10px;" class="col-form-label"><?php echo $headname ?>!</label>
                                </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    window.onload = function() {
        setInterval(function() {
            $.ajax({
                type: "POST",
                url: "ajax/order-count.php",
                data:{'id':<?php echo $headid ?>},
                success: function(data)
                {
                    $('#counter').html(data);
                    $.ajax({
                        type: "POST",
                        url: "ajax/order-detail.php",
                        data:{'id':<?php echo $headid ?>},
                        success: function(data)
                        {
                            $('#order-notification').html(data);
                            $.ajax({
                                type: "POST",
                                url: "ajax/order-notification.php",
                                data:{'id':<?php echo $headid ?>},
                                success: function(data)
                                {
                                    if(data == 1)
                                    {
                                        var sound = document.getElementById("audio");
                                        sound.play();
                                    }
                                }
                            });
                        }
                    });
                }
            });
        }, 10000);
    }
</script>