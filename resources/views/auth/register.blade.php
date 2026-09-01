<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {

            overflow: hidden;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #020711;

            color: white;

        }


        /* =====================================================
           PAGE
        ===================================================== */

        .register-page {

            width: 100vw;
            height: 100vh;

            position: relative;

            overflow: hidden;

            background: #020711;

        }


        /* =====================================================
           ANIME BACKGROUND
        ===================================================== */

        .anime-background {

            position: absolute;

            inset: -4%;

            background-image:
                url('/assets/register-bg.jpeg');

            background-size: cover;

            background-position: center;

            transform:
                scale(1.05);

            animation:
                cinematicZoom
                16s
                ease-in-out
                infinite alternate;

            filter:
                saturate(1.08)
                contrast(1.05);

        }


        @keyframes cinematicZoom {

            0% {

                transform:
                    scale(1.05)
                    translate3d(0, 0, 0);

            }

            50% {

                transform:
                    scale(1.10)
                    translate3d(-0.7%, -0.4%, 0);

            }

            100% {

                transform:
                    scale(1.06)
                    translate3d(0.7%, 0.5%, 0);

            }

        }


        /* =====================================================
           DARK GRADIENT
        ===================================================== */

        .background-overlay {

            position: absolute;

            inset: 0;

            background:

                linear-gradient(
                    90deg,
                    rgba(1, 5, 12, .97) 0%,
                    rgba(1, 5, 12, .91) 27%,
                    rgba(1, 5, 12, .55) 45%,
                    rgba(1, 5, 12, .05) 75%
                );

            z-index: 2;

        }


        .bottom-overlay {

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: 28%;

            background:
                linear-gradient(
                    transparent,
                    rgba(0, 4, 12, .9)
                );

            z-index: 3;

        }


        /* =====================================================
           BLUE AURA
        ===================================================== */

        .aura {

            position: absolute;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            right: 7%;
            top: 20%;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 110, 255, .24),
                    rgba(0, 80, 255, .08) 35%,
                    transparent 70%
                );

            filter: blur(10px);

            z-index: 3;

            animation:
                auraPulse
                4s
                ease-in-out
                infinite;

            pointer-events: none;

        }


        @keyframes auraPulse {

            0% {

                transform:
                    scale(.88);

                opacity:
                    .45;

            }

            50% {

                transform:
                    scale(1.15);

                opacity:
                    .9;

            }

            100% {

                transform:
                    scale(.88);

                opacity:
                    .45;

            }

        }


        /* =====================================================
           ENERGY RING
        ===================================================== */

        .energy-ring {

            position: absolute;

            width: 600px;
            height: 600px;

            right: 1%;
            top: 12%;

            border-radius: 50%;

            border:
                2px solid
                rgba(0, 145, 255, .15);

            box-shadow:

                0 0 25px
                rgba(0, 120, 255, .15),

                inset 0 0 25px
                rgba(0, 120, 255, .1);

            z-index: 3;

            animation:
                ringRotate
                18s
                linear
                infinite;

            pointer-events: none;

        }


        .energy-ring::before {

            content: "";

            position: absolute;

            inset: 35px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255, 255, 255, .08);

        }


        @keyframes ringRotate {

            from {
                transform:
                    rotate(0deg);
            }

            to {
                transform:
                    rotate(360deg);
            }

        }


        /* =====================================================
           PARTICLES
        ===================================================== */

        .particles {

            position: absolute;

            inset: 0;

            z-index: 5;

            pointer-events: none;

        }


        .particle {

            position: absolute;

            width: 4px;
            height: 4px;

            border-radius: 50%;

            background: #8bd8ff;

            box-shadow:
                0 0 10px
                rgba(0, 170, 255, .9);

            animation:
                particleMove
                var(--duration)
                linear
                infinite;

            animation-delay:
                var(--delay);

            left:
                var(--left);

            bottom:
                -20px;

        }


        .particle.orange {

            background:
                #ff713c;

            box-shadow:
                0 0 10px
                rgba(255, 70, 30, .9);

        }


        @keyframes particleMove {

            0% {

                transform:
                    translate3d(
                        0,
                        0,
                        0
                    )
                    rotate(0deg);

                opacity: 0;

            }

            10% {

                opacity: 1;

            }

            50% {

                transform:
                    translate3d(
                        var(--moveX),
                        -50vh,
                        0
                    )
                    rotate(180deg);

            }

            100% {

                transform:
                    translate3d(
                        calc(var(--moveX) * -1),
                        -110vh,
                        0
                    )
                    rotate(360deg);

                opacity: 0;

            }

        }


        /* =====================================================
           ENERGY STREAKS
        ===================================================== */

        .energy-streak {

            position: absolute;

            width: 250px;
            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #38aaff,
                    transparent
                );

            opacity: .65;

            z-index: 5;

            transform:
                rotate(-22deg);

            animation:
                streakMove
                4s
                linear
                infinite;

        }


        .energy-streak.one {

            right: 5%;
            top: 30%;

            animation-delay:
                -1s;

        }


        .energy-streak.two {

            right: 25%;
            top: 55%;

            animation-delay:
                -2.4s;

        }


        .energy-streak.three {

            right: 10%;
            top: 75%;

            animation-delay:
                -.5s;

        }


        @keyframes streakMove {

            0% {

                transform:
                    translateX(150px)
                    rotate(-22deg);

                opacity: 0;

            }

            20% {

                opacity: .8;

            }

            70% {

                opacity: .8;

            }

            100% {

                transform:
                    translateX(-500px)
                    rotate(-22deg);

                opacity: 0;

            }

        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .content {

            position: relative;

            z-index: 20;

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;

        }


        /* =====================================================
           REGISTER PANEL
        ===================================================== */

        .register-panel {

            width: 43%;

            min-width: 500px;

            height: 100%;

            padding:
                55px 65px;

            display: flex;

            align-items: center;

            position: relative;

            background:
                linear-gradient(
                    90deg,
                    rgba(1, 5, 12, .98),
                    rgba(1, 7, 15, .91)
                );

            border-right:
                1px solid
                rgba(80, 180, 255, .15);

            box-shadow:
                15px 0 70px
                rgba(0,0,0,.5);

            animation:
                panelEnter
                .9s
                cubic-bezier(.2,.8,.2,1);

        }


        @keyframes panelEnter {

            from {

                opacity: 0;

                transform:
                    translateX(-60px);

            }

            to {

                opacity: 1;

                transform:
                    translateX(0);

            }

        }


        .panel-content {

            width: 100%;

            max-width: 430px;

        }


        /* =====================================================
           SYSTEM LABEL
        ===================================================== */

        .system-label {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 32px;

            color:
                #8edaff;

            font-size: 11px;

            letter-spacing:
                .28em;

            font-weight:
                800;

        }


        .system-dot {

            width: 9px;
            height: 9px;

            border-radius: 50%;

            background:
                #29aaff;

            box-shadow:
                0 0 14px
                #159cff;

            animation:
                dotPulse
                1.5s
                infinite;

        }


        @keyframes dotPulse {

            0%,
            100% {

                opacity: .4;

                transform:
                    scale(.8);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.2);

            }

        }


        /* =====================================================
           TITLE
        ===================================================== */

        .title {

            font-size:
                clamp(42px, 4vw, 66px);

            line-height:
                .9;

            letter-spacing:
                -.055em;

            font-weight:
                950;

            text-transform:
                uppercase;

            margin-bottom:
                18px;

        }


        .title span {

            color:
                #38aaff;

            text-shadow:
                0 0 25px
                rgba(0, 145, 255, .35);

        }


        .description {

            max-width:
                390px;

            color:
                rgba(220,235,250,.6);

            font-size:
                12px;

            line-height:
                1.7;

            margin-bottom:
                28px;

        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {

            margin-bottom:
                13px;

        }


        .form-label {

            display: block;

            margin-bottom:
                7px;

            color:
                #91a7bb;

            font-size:
                9px;

            font-weight:
                800;

            letter-spacing:
                .18em;

            text-transform:
                uppercase;

        }


        .input-box {

            position: relative;

        }


        .input-box input {

            width: 100%;

            height: 51px;

            padding:
                0 15px;

            border:
                1px solid
                rgba(150,190,220,.18);

            border-radius:
                5px;

            outline: none;

            background:
                rgba(5, 14, 25, .78);

            color: white;

            font-size:
                12px;

            transition:
                .25s;

        }


        .input-box input:focus {

            border-color:
                rgba(50,170,255,.75);

            background:
                rgba(5, 20, 35, .9);

            box-shadow:
                0 0 0 3px
                rgba(0,130,255,.08),

                0 0 25px
                rgba(0,120,255,.08);

        }


        .input-box input::placeholder {

            color:
                rgba(180,200,220,.35);

        }


        /* =====================================================
           TWO COLUMNS
        ===================================================== */

        .two-columns {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                12px;

        }


        /* =====================================================
           PASSWORD BUTTON
        ===================================================== */

        .password-toggle {

            position: absolute;

            right: 6px;
            top: 6px;

            width: 39px;
            height: 39px;

            border: none;

            background:
                transparent;

            color:
                #7890a6;

            cursor: pointer;

            border-radius:
                5px;

            transition:
                .2s;

        }


        .password-toggle:hover {

            color:
                #43b4ff;

            background:
                rgba(50,150,255,.08);

        }


        /* =====================================================
           TERMS
        ===================================================== */

        .terms {

            display: flex;

            align-items:
                center;

            gap: 8px;

            margin:
                16px 0 20px;

            font-size:
                10px;

            color:
                #77899b;

        }


        .terms input {

            appearance:
                none;

            width:
                15px;

            height:
                15px;

            border:
                1px solid
                #42586b;

            border-radius:
                3px;

            background:
                #07111d;

            cursor:
                pointer;

        }


        .terms input:checked {

            border-color:
                #249fff;

            background:
                #168cff;

            box-shadow:
                0 0 10px
                rgba(0,145,255,.4);

        }


        /* =====================================================
           REGISTER BUTTON
        ===================================================== */

        .register-button {

            position: relative;

            width: 100%;

            height: 56px;

            border: none;

            border-radius:
                5px;

            background:
                linear-gradient(
                    90deg,
                    #075ed6,
                    #00a5ff
                );

            color:
                white;

            font-size:
                12px;

            font-weight:
                900;

            letter-spacing:
                .22em;

            cursor:
                pointer;

            overflow:
                hidden;

            box-shadow:
                0 10px 35px
                rgba(0,120,255,.22);

            transition:
                .3s;

        }


        .register-button::before {

            content: "";

            position: absolute;

            top: 0;
            left: -120%;

            width: 80%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.45),
                    transparent
                );

            transform:
                skewX(-20deg);

            animation:
                buttonSweep
                3s
                infinite;

        }


        @keyframes buttonSweep {

            0% {

                left:
                    -120%;

            }

            45%,
            100% {

                left:
                    160%;

            }

        }


        .register-button:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 15px 45px
                rgba(0,145,255,.4);

        }


        /* =====================================================
           LOGIN
        ===================================================== */

        .login {

            text-align:
                center;

            margin-top:
                18px;

            color:
                #6d8194;

            font-size:
                11px;

        }


        .login a {

            color:
                #42b4ff;

            text-decoration:
                none;

            font-weight:
                800;

            margin-left:
                5px;

        }


        .login a:hover {

            text-decoration:
                underline;

        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {

            margin-top:
                27px;

            padding-top:
                16px;

            border-top:
                1px solid
                rgba(150,190,220,.1);

            color:
                rgba(180,200,220,.35);

            font-size:
                9px;

            letter-spacing:
                .12em;

        }


        .footer span {

            color:
                #269eff;

        }


        /* =====================================================
           CAMERA LIGHT
        ===================================================== */

        .cursor-light {

            position:
                fixed;

            width:
                350px;

            height:
                350px;

            border-radius:
                50%;

            pointer-events:
                none;

            z-index:
                15;

            transform:
                translate(-50%, -50%);

            background:
                radial-gradient(
                    circle,
                    rgba(0,145,255,.12),
                    transparent 70%
                );

            mix-blend-mode:
                screen;

        }


        /* =====================================================
           SCANLINE
        ===================================================== */

        .scanline {

            position:
                absolute;

            left: 0;
            right: 0;

            height: 1px;

            background:
                rgba(80,190,255,.18);

            z-index:
                30;

            pointer-events:
                none;

            animation:
                scanMove
                7s
                linear
                infinite;

        }


        @keyframes scanMove {

            from {

                top:
                    -5%;

            }

            to {

                top:
                    105%;

            }

        }


        /* =====================================================
           ERROR
        ===================================================== */

        .error-message {

            margin:
                5px 0 10px;

            color:
                #ff6575;

            font-size:
                10px;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width: 900px) {

            .register-panel {

                width: 100%;

                min-width: 0;

                background:
                    rgba(1,6,14,.88);

                backdrop-filter:
                    blur(10px);

            }

            .anime-background {

                background-position:
                    60% center;

            }

        }


        @media(max-width: 600px) {

            .register-panel {

                padding:
                    35px 25px;

            }

            .two-columns {

                grid-template-columns:
                    1fr;

                gap: 0;

            }

            .title {

                font-size:
                    43px;

            }

        }

    </style>

</head>


<body>


<div
    class="register-page"
    id="registerPage"
>


    <!-- =====================================================
         BACKGROUND
    ====================================================== -->

    <div
        class="anime-background"
        id="animeBackground"
    ></div>


    <div class="background-overlay"></div>

    <div class="bottom-overlay"></div>


    <!-- AURA -->

    <div class="aura"></div>

    <div class="energy-ring"></div>


    <!-- =====================================================
         PARTICLES
    ====================================================== -->

    <div class="particles">

        <span
            class="particle"
            style="
                --left:8%;
                --duration:7s;
                --delay:-2s;
                --moveX:70px;
            "
        ></span>

        <span
            class="particle"
            style="
                --left:17%;
                --duration:9s;
                --delay:-5s;
                --moveX:-50px;
            "
        ></span>

        <span
            class="particle"
            style="
                --left:31%;
                --duration:6s;
                --delay:-1s;
                --moveX:100px;
            "
        ></span>

        <span
            class="particle orange"
            style="
                --left:47%;
                --duration:8s;
                --delay:-4s;
                --moveX:-90px;
            "
        ></span>

        <span
            class="particle"
            style="
                --left:58%;
                --duration:10s;
                --delay:-7s;
                --moveX:50px;
            "
        ></span>

        <span
            class="particle orange"
            style="
                --left:69%;
                --duration:7s;
                --delay:-3s;
                --moveX:-70px;
            "
        ></span>

        <span
            class="particle"
            style="
                --left:79%;
                --duration:9s;
                --delay:-6s;
                --moveX:80px;
            "
        ></span>

        <span
            class="particle"
            style="
                --left:91%;
                --duration:6s;
                --delay:-2s;
                --moveX:-100px;
            "
        ></span>

    </div>


    <!-- ENERGY -->

    <div class="energy-streak one"></div>
    <div class="energy-streak two"></div>
    <div class="energy-streak three"></div>


    <!-- SCAN -->

    <div class="scanline"></div>


    <!-- =====================================================
         MAIN
    ====================================================== -->

    <div class="content">


        <!-- =================================================
             REGISTER
        ================================================== -->

        <section class="register-panel">


            <div class="panel-content">


                <!-- SYSTEM -->

                <div class="system-label">

                    <span class="system-dot"></span>

                    EQUIPMENT MAINTENANCE SYSTEM

                </div>


                <!-- TITLE -->

                <h1 class="title">

                    CREATE<br>

                    <span>ACCOUNT</span>

                </h1>


                <p class="description">

                    Create your account and access
                    the equipment maintenance system.

                </p>


                <!-- =================================================
                     FORM
                ================================================== -->

                <form
                    action="{{ route('register.store') }}"
                    method="POST"
                >

                    @csrf


                    <!-- NAME + USERNAME -->

                    <div class="two-columns">


                        <div class="form-group">

                            <label class="form-label">
                                Full Name
                            </label>

                            <div class="input-box">

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Full name"
                                    required
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Username
                            </label>

                            <div class="input-box">

                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="Username"
                                    required
                                >

                            </div>

                        </div>


                    </div>


                    <!-- EMAIL -->

                    <div class="form-group">

                        <label class="form-label">
                            Email
                        </label>

                        <div class="input-box">

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                required
                            >

                        </div>

                    </div>


                    <!-- PASSWORD -->

                    <div class="two-columns">


                        <div class="form-group">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="input-box">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword(
                                        'password',
                                        this
                                    )"
                                >

                                    ◉

                                </button>

                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <div class="input-box">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Confirm"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword(
                                        'password_confirmation',
                                        this
                                    )"
                                >

                                    ◉

                                </button>

                            </div>

                        </div>


                    </div>


                    <!-- ERRORS -->

                    @if ($errors->any())

                        <div class="error-message">

                            {{ $errors->first() }}

                        </div>

                    @endif


                    <!-- TERMS -->

                    <label class="terms">

                        <input
                            type="checkbox"
                            required
                        >

                        <span>
                            I agree to the terms and conditions
                        </span>

                    </label>


                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="register-button"
                    >

                        CREATE ACCOUNT

                    </button>


                </form>


                <!-- LOGIN -->

                <div class="login">

                    Already have an account?

                    <a href="{{ route('login') }}">
                        LOG IN
                    </a>

                </div>


                <!-- FOOTER -->

                <div class="footer">

                    <span>KSP</span>

                    MAINTENANCE SYSTEM

                    © 2025

                </div>


            </div>


        </section>


    </div>


    <!-- CURSOR LIGHT -->

    <div
        class="cursor-light"
        id="cursorLight"
    ></div>


</div>



<script>


    /* =====================================================
       PASSWORD
    ===================================================== */

    function togglePassword(id, button) {

        const input =
            document.getElementById(id);

        if (input.type === "password") {

            input.type = "text";

            button.textContent = "◉";

        } else {

            input.type = "password";

            button.textContent = "○";

        }

    }


    /* =====================================================
       CURSOR
    ===================================================== */

    const page =
        document.getElementById(
            "registerPage"
        );

    const background =
        document.getElementById(
            "animeBackground"
        );

    const cursorLight =
        document.getElementById(
            "cursorLight"
        );


    let mouseX = 0;
    let mouseY = 0;

    let currentX = 0;
    let currentY = 0;


    page.addEventListener(
        "mousemove",
        function(event) {

            mouseX =
                event.clientX;

            mouseY =
                event.clientY;

        }
    );


    /* =====================================================
       CINEMATIC MOUSE PARALLAX
    ===================================================== */

    function animate() {


        currentX +=
            (
                mouseX -
                currentX
            ) * .05;


        currentY +=
            (
                mouseY -
                currentY
            ) * .05;


        const centerX =
            window.innerWidth / 2;


        const centerY =
            window.innerHeight / 2;


        const moveX =
            (
                currentX -
                centerX
            ) * .008;


        const moveY =
            (
                currentY -
                centerY
            ) * .005;


        background.style.transform =
            `
                scale(1.06)
                translate(
                    ${moveX}px,
                    ${moveY}px
                )
            `;


        cursorLight.style.left =
            currentX + "px";


        cursorLight.style.top =
            currentY + "px";


        requestAnimationFrame(
            animate
        );

    }


    animate();


    /* =====================================================
       INPUT ENERGY EFFECT
    ===================================================== */

    document
        .querySelectorAll(
            ".input-box input"
        )
        .forEach(
            function(input) {

                input.addEventListener(
                    "focus",
                    function() {

                        this.parentElement
                            .style
                            .filter =
                            "drop-shadow(0 0 8px rgba(0,150,255,.12))";

                    }
                );


                input.addEventListener(
                    "blur",
                    function() {

                        this.parentElement
                            .style
                            .filter =
                            "none";

                    }
                );

            }
        );


</script>


</body>

</html>