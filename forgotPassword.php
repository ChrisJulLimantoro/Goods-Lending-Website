<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <style>
        *,::after,::before{
            box-sizing:border-box;
        }
        .box{
            padding: 45px;
            background-color:rgba(255,255,255,.95);
            box-shadow: 1px 0px 17px -5px rgba(0,0,0,0.75);
            border-radius:10px;
        }
        .header {
            position:relative;
            background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        }
        .waves {
            position:relative;
            width: 100%;
            height:20vh;
            margin-bottom:-7px; /*Fix for safari gap*/
            min-height:100px;
            max-height:150px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes move-forever {
            0% {
            transform: translate3d(-90px,0,0);
            }
            100% { 
                transform: translate3d(85px,0,0);
            }
        }
        .flex { /*Flexbox for containers*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* TITLE */
        .spinner {
        align-items: center;
        height: 50px;
        width: max-content;
        font-size: 48px;
        font-weight: 800;
        font-family: monospace;
        letter-spacing: 0.3em;
        color: #2B3467;
        filter: drop-shadow(0 0 10px);
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .spinner span {
        font-size: 32px;
        animation: loading6454 1.75s ease infinite;
        }

        .spinner:hover{
            color: #82C3EC;
        }

        .spinner span:nth-child(2) {
        animation-delay: 0.25s;
        }

        .spinner span:nth-child(3) {
        animation-delay: 0.5s;
        }

        .spinner span:nth-child(4) {
        animation-delay: 0.75s;
        }

        .spinner span:nth-child(5) {
        animation-delay: 1s;
        }

        .spinner span:nth-child(6) {
        animation-delay: 1.25s;
        }

        .spinner span:nth-child(7) {
        animation-delay: 1.5s;
        }

        @keyframes loading6454 {
        0%, 100% {
        transform: translateY(0);
        }

        50% {
        transform: translateY(-10px);
        }
        }

        /* new button */
        button {
            font-family: inherit;
            font-size: 20px;
            background: royalblue;
            color: white;
            padding: 0.7em 1em;
            padding-left: 0.9em;
            display: flex;
            float: right;
            align-items: center;
            height: 2em;
            width: 7em;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.2s;
            }

        button span {
        display: block;
        margin-left: 0.7em;
        transition: all 0.3s ease-in-out;
        }

        button svg {
        display: block;
        transform-origin: center center;
        transition: transform 0.3s ease-in-out;
        }

        button:hover .svg-wrapper {
        animation: fly-1 0.6s ease-in-out infinite alternate;
        }

        button:hover svg {
        transform: translateX(1.2em) rotate(45deg) scale(1.1);
        }

        button:hover span {
        transform: translateX(5em);
        }

        button:active {
        transform: scale(0.95);
        }

        @keyframes fly-1 {
        from {
            
            transform: translateY(0.1em);
        }

        to {
            margin-left: 1em;
            transform: translateY(-0.1em);
        }
        }

        /* background */

        .waves {
            position:relative;
            width: 100%;
            height:20vh;
            margin-bottom:-7px; /*Fix for safari gap*/
            min-height:100px;
            max-height:150px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes move-forever {
            0% {
            transform: translate3d(-90px,0,0);
            }
            100% { 
                transform: translate3d(85px,0,0);
            }
        }
        .flex { /*Flexbox for containers*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>
<body>
    <div class="header pt-5">
    <!--Waves Container-->
    <div class="container-fluid d-flex align-items-center justify-content-center pt-3">
        <div class="row" style="width: 100%">
            <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
            <div class="col-lg-4 col-md-6 col-sm-8 col-10 box text-center">
            <div class="spinner">
                <span>F</span>
                <span>O</span>
                <span>R</span>
                <span>G</span>
                <span>O</span>
                <span>T</span>
            </div>
            <div class="spinner">
                
                <span>P</span>
                <span>A</span>
                <span>S</span>
                <span>S</span>
                <span>W</span>
                <span>O</span>
                <span>R</span>
                <span>D</span>
            </div>
                <!-- <h4 class="subtitle-login text-center" style="border-bottom:1px solid black;line-height:0.1em;"></h4> -->
                <form action="" method="post">
                    <div class="mb-3">
                        <br>
                        <div class="container-fluid position-relative p-0">
                            <label for="inputEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control text-center" id="inputEmail" aria-describedby="userHelp" name="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="container-fluid position-relative p-0">
                            <label for="inputPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control text-center" id="inputPassword" aria-describedby="passHelp" name="pass" placeholder="Your New Password">
                            <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="passHelp" class="form-text">must be 8-20 characters</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="container-fluid position-relative p-0">
                            <label for="inputConfirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control text-center" id="inputConfirm" aria-describedby="passHelp" name="pass" placeholder="Confirm..">
                            <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button>
                            <div class="svg-wrapper-1">
                                <div class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                                </svg>
                                </div>
                            </div>
                            <span>Change</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div>
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
        <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
        </svg>
    </div>
    <!--Waves end-->

    </div>
    
</body>
</html>