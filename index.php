<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Plant & energy (Pvt) Ltd |Login</title>
    <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .bars {
            width: 21.6px;
            height: 28.8px;
            --c: linear-gradient(#ffffff 0 0);
            background: var(--c) 0% 50%,
                var(--c) 50% 50%,
                var(--c) 100% 50%;
            background-size: 4.3px 50%;
            background-repeat: no-repeat;
            animation: bars-7s9ul0mn 1s infinite linear alternate;
        }

        @keyframes bars-7s9ul0mn {
            20% {
                background-size: 4.3px 20%, 4.3px 50%, 4.3px 50%;
            }

            40% {
                background-size: 4.3px 100%, 4.3px 20%, 4.3px 50%;
            }

            60% {
                background-size: 4.3px 50%, 4.3px 100%, 4.3px 20%;
            }

            80% {
                background-size: 4.3px 50%, 4.3px 50%, 4.3px 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="row pt-5">
            <div class="left col-lg-6 col-md-12 col-sm-12">
                <div class="content">
                    <img src="resourses/lo.png" alt="" width="20%" style="margin-bottom: 20px;">
                    <h1 style=" font-size: 30px;"><span style="color: #07c06a ; ">Eco </span>Plant & Energy <span style="color: gray ; font-size: 22px; font-weight: bold; ">(Pvt) Ltd.</span></h1>

                    <h5 style=" font-size: 31px; font-weight: bold; margin-bottom: 30px;">User<span style="color: #07c06a ; "> Login</span> </h5>

                </div>


            </div>
            <div class="right col-lg-6 col-12">
                <div class="alert alert-danger align-content-center mt-3 ps-0 pt-0 m-0 d-none " role="alert" style="height: 30px;  display: flex; " id="erroshow">
                    labelA simple danger alert—check it out!
                </div>
                <div class="content-2">
                    <?php
                    $username = "";
                    if (isset($_COOKIE["username"])) {
                        $username = $_COOKIE["username"];
                    }
                    ?>
                    <label for="uname" class="lab">Username:</label><br>
                    <input type="text" id="uname" class="entry_f uname " value="<?php echo $username; ?>" placeholder="Enter User Name" onclick="hidealert();"><br>
                    <label for="pw" class="lab">Password:</label><br>
                    <input type="password" id="pw" class="entry_f pw" placeholder="Enter Password" onclick="hidealert();"><br>
                    <div class="col-lg-6 d-flex justify-content-start">
                        <a href="#" class="link-primary text-decoration-none link-secondary" onclick="forgotPassword();">Fogot Password?</a>
                    </div>
                    <button id="lbtn" class="btn btn-success log-btn" onclick="login();">Login</button><br>
                    <p class="copytag" style="text-decoration: none; text-align: left;">Powerd By @Affinity Software Solutions</p>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal" tabindex="-1" id="forgotpassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class=" row g-3">
                        <div class=" col-6">
                            <label class=" form-label">New Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="fp">
                                <button class="btn btn-outline-secondary" type="button" onclick="showPassword4();"><i class="bi bi-eye-slash-fill" id="fpb"></i></button>
                            </div>
                        </div>
                        <div class=" col-6">
                            <label class=" form-label">Re-type Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="fp2">
                                <button class="btn btn-outline-secondary" type="button" onclick="showPassword5();"><i class="bi bi-eye-slash-fill" id="fpb2"></i></button>
                            </div>
                        </div>
                        <div class=" col-12">
                            <label class=" form-label">Verification Code (Please Check in the Email.)</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="vc">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset Password</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->


    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>