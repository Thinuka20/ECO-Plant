<?php
session_start();

include "connection.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Eco Plant & Energy (Pvt) Ltd | Salaries</title>

    <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <style>

        h1 {
            font-size: 3em;
        }

        p {
            font-size: 1.5em;
            color: #777;
        }

        .countdown {
            margin-top: 30px;
            font-size: 2em;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1.2em;
            }

            .countdown {
                font-size: 1.5em;
            }
        }
    </style>
</head>

<body style="overflow-x: hidden;">
    <?php
    require "navbar.php";
    ?>
    <div class="row">
        <!-- left side -->
        <?php
        require "leftside.php";
        ?>
        <!-- right side -->
        <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5">
            <div class="col-lg-10 offset-lg-1 d-flex justify-content-center align-items-center vh-100">
                <div class="row">
                        <div class="col-12">
                            <p class="headings text-center">Coming Soon</p>
                        </div>
                        <div class="col-12">
                            <p class="text-center">We're working hard to bring you an amazing website!</p>
                        </div>
                        <div class="countdown col-12 mt-0">
                            <p class="text-center" id="countdown"></p>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("May 1, 2024 00:00:00").getTime();

        // Update the countdown every 1 second
        var x = setInterval(function() {

            // Get the current date and time
            var now = new Date().getTime();

            // Calculate the time remaining
            var distance = countDownDate - now;

            // Calculate days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the countdown
            document.getElementById("countdown").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the countdown is over, display a message
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>





</html>