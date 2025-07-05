<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Log in</title>
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/adminlte.min.css'); ?>">
    <!-- Google Font -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('<?php echo base_url("assets/template/dist/img/loginbg.jpg"); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
        }

        .login-box {
            width: 750px;
            max-width: 85%;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 0;
            background: none;
        }

        .login-columns {
            display: flex;
            min-height: 420px;
        }

        .character-column {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            position: relative;
        }

        .character-image {
            max-width: 100%;
            max-height: 320px;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
        }

        .form-column {
            flex: 1;
            background-image: url('<?php echo base_url("assets/template/dist/img/rb_161.png"); ?>');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 30px;
            display: flex;
            align-items: center;
        }

        .form-column::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .form-content {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .login-box-msg {
            color: white;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 25px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #ffc107;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.3);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-left: none;
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0 25px 25px 0;
        }

        .input-group .form-control {
            border-radius: 25px 0 0 25px;
        }

        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #ffca2c);
            border: none;
            color: #333;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: linear-gradient(45deg, #ffca2c, #ffd700);
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }

        .icheck-primary label {
            color: white !important;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .login-box {
                width: 100%;
                margin: 0;
            }

            .login-columns {
                flex-direction: column;
                min-height: auto;
            }

            .character-column {
                padding: 20px;
                min-height: 200px;
            }

            .character-image {
                max-height: 150px;
            }

            .form-column {
                padding: 30px 20px;
            }
        }

        @media (max-width: 576px) {
            .login-logo {
                margin-bottom: 1rem;
            }

            .form-column {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url(); ?>" style="font-size: 30px; color:#2a5298; font-family: 'Montserrat', sans-serif; font-weight: 500;"><b>FreeRADIUS Login</b></a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="login-columns">
                    <!-- Kolom Kiri - Gambar Karakter 3D -->
                    <div class="character-column">
                        <img src="<?php echo base_url('assets/template/dist/img/karakter3d.png'); ?>"
                            alt="3D Character"
                            class="character-image">
                    </div>

                    <!-- Kolom Kanan - Form Login -->
                    <div class="form-column">
                        <div class="form-content">
                            <p class="login-box-msg">Sign in to start your session</p>

                            <form action="<?php echo base_url('auth/login'); ?>" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="remember" name="remember">
                                            <label for="remember">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-warning btn-block">Sign In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE -->
    <script src="<?php echo base_url('assets/template/dist/js/adminlte.min.js'); ?>"></script>

    <script>
        $(document).ready(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 3000
            };

            <?php if ($this->session->flashdata('success')) : ?>
                toastr.success("<?= $this->session->flashdata('success'); ?>");
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')) : ?>
                toastr.error("<?= $this->session->flashdata('error'); ?>");
            <?php endif; ?>
        });
    </script>
</body>

</html>