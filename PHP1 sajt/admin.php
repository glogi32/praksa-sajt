<?php
	session_start();
	include "konekcija.php";
	if(!isset($_SESSION['korisnik'])){
		$_SESSION['greska'] = "NISTE ULOGOVANI!";
		header("Location: index.php");
	}
	if($_SESSION['korisnik']->uloga_id != 1){
		$_SESSION['greska'] = "NISTE ADMINISTRATOR!";
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bootstrap E-Commerce Template- DIGI Shop mini</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Fontawesome core CSS -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <!--GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!--Slide Show Css -->
    <link href="assets/ItemSlider/css/main-style.css" rel="stylesheet" />
    <!-- custom CSS here -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="assets/css/mystyle.css" rel="stylesheet" />
</head>
<body>
    <div id="mySidenavInsert" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNavInsert()">&times;</a>
            <form id="formaLogin">
                <div class="container2">
                    <h1>Add new user</h1>
                    <p>Please fill in this form to add new user.</p>
                    <hr>
                    <input type="hidden" id="tbHidden" />

                    <label for="fname"><b>First name</b></label>
                    <input type="text" id="tbFname" placeholder="Enter first name" name="fname">

                    <label for="lname"><b>Last name</b></label>
                    <input type="text" id="tbLname" placeholder="Enter last name" name="lname">

                    <label for="e_mail"><b>E-mail</b></label>
                    <input type="text" id="tbE_mail" placeholder="Enter email" name="e_mail">
                
                    <label for="pass"><b>Password</b></label>
                    <input type="text" id="tbPassword" placeholder="Enter Password" name="pass">

                    <label for="uloge"><b>Role</b></label>
                    <select id="uloge">
                    <option value="0">Choose..</option>
                    <?php
                        $rez = executeQuery("SELECT * FROM uloge");
                        if(count($rez) == 0){
                            http_response_code(400);
                        }            
                        
                        foreach($rez as $r) :  ?>  
                                <option value="<?= $r->uloga_id?>"><?= $r->naziv?></option>
                         <?php endforeach;?>
                    </select>
                    <div class="clearfix">
                        <input type="button" id="btnCancelAdd" class="cancelbtn" value="Cancel" />
                        <input type="button" id="btnAdd" name="btnAdd" class="loginbtn"  value="Add user"/>
                    </div>
                </div>
            </form>
    </div>

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><strong>Electronics</strong> Shop</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
                    <li><a href="index.php">Home</a></li>
                    <?php 
                        if(isset($_SESSION['korisnik'])) :
                            if($_SESSION['korisnik']->uloga_id == 1) : ?>
                                <li><a href="admin.php" id="admin">Admin</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php" id="logout">Logout</a></li>
                            <li><a href="#"> Hello <?php echo $_SESSION['korisnik']->ime ?></a>
                            <?php else: ?>
                            <li><a href="#" id="login">Login</a></li>
                            <li><a href="#" id="signup">Signup</a></li>
                        <?php endif; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">24x7 Support <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><strong>Call: </strong>+09-456-567-890</a></li>
                            <li><a href="#"><strong>Mail: </strong>info@yourdomain.com</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><strong>Address: </strong>
                                <div>
                                    234, New york Street,<br />
                                    Just Location, USA
                                </div>
                            </a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" placeholder="Enter Keyword Here ..." class="form-control">
                    </div>
                    &nbsp; 
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div id="sredina">
        <h1 id="admin-naslov">ADMIN PAGE</h1>
        <p id="addNew"><i class="fas fa-user-plus"></i> Add new user</p>
        <div id="admin-tabela-okvir">
            <table id="table-users">
                
                
            </table>
        </div>
    </div>
    <!-- /.container -->
    <div class="col-md-12 download-app-box text-center">

        <span class="glyphicon glyphicon-download-alt"></span>Download Our Android App and Get 10% additional Off on all Products . <a href="#" class="btn btn-danger btn-lg">DOWNLOAD  NOW</a>

    </div>

    <!--Footer -->
    <div class="col-md-12 footer-box">


        
        <div class="row">
            <div class="col-md-4">
                <strong>Send a Quick Query </strong>
                <hr>
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" required="required" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" required="required" placeholder="Email address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <textarea name="message" id="message" required="required" class="form-control" rows="3" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <strong>Our Location</strong>
                <hr>
                <p>
                     234, New york Street,<br />
                                    Just Location, USA<br />
                    Call: +09-456-567-890<br>
                    Email: info@yourdomain.com<br>
                </p>

                2014 www.yourdomain.com | All Right Reserved
            </div>
            <div class="col-md-4 social-box">
                <strong>We are Social </strong>
                <hr>
                <a href="#"><i class="fa fa-facebook-square fa-3x "></i></a>
                <a href="#"><i class="fa fa-twitter-square fa-3x "></i></a>
                <a href="#"><i class="fa fa-google-plus-square fa-3x c"></i></a>
                <a href="#"><i class="fa fa-linkedin-square fa-3x "></i></a>
                <a href="#"><i class="fa fa-pinterest-square fa-3x "></i></a>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nec nisl odio. Mauris vehicula at nunc id posuere. Curabitur nec nisl odio. Mauris vehicula at nunc id posuere. 
                </p>
            </div>
        </div>
        <hr>
    </div>
    <!-- /.col -->
    <div class="col-md-12 end-box ">
        &copy; 2014 | &nbsp; All Rights Reserved | &nbsp; www.yourdomain.com | &nbsp; 24x7 support | &nbsp; Email us: info@yourdomain.com | <a href="DokumentacijaPHP.pdf" target="_blank" >Dokumentacija</a> | <a href="oAutoru.php">O autoru</a>
    </div>
    <!-- /.col -->
    <!--Footer end -->
    <!--Core JavaScript file  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!--bootstrap JavaScript file  -->
    <script src="assets/js/bootstrap.js"></script>
    <!--Slider JavaScript file  -->
    <script src="assets/ItemSlider/js/modernizr.custom.63321.js"></script>
    <script src="assets/ItemSlider/js/jquery.catslider.js"></script>
    <script src="assets/js/main.js"></script>
    <script>    
        $(function () {

            $('#mi-slider').catslider();

        });
		</script>
</body>
</html>
