<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUBA SEWANA PRIVATE HOSPITAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous" defer></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ebebeb;
        }

        .container {
            height: 99vh;
        }

        .colPadding {
            padding: 50px 20px;
        }

        .divider {
            border-right: solid 3px rgb(44, 44, 44);
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['error'])) {
    ?>
        <h6 class='position-fixed w-100 text-center p-3 text-white bg-danger' style="z-index:1000">Username or Password is incorrect, Try again!</h6>
    <?php
    }
    ?>
    <main class="container d-flex align-items-center justify-content-around">

        <!-- <h1 class="h1 py-5 mt-2 text-center bg-dark text-light rounded shadow"> SUBA SEWANA PRIVATE HOSPITAL</h1> -->
        <div class="row w-100">
            <div class="col-md-6 colPadding divider">
                <div class="card shadow h-100">
                    <div class="card-header ">
                        <div class="header">
                            <small class="small">Prepared by</small>
                            <h2 class="h2 pd-5">GROUP 28</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">20001061</th>
                                    <td>MADARASINGHE J.P.</td>
                                </tr>
                                <tr>
                                    <th scope="row">20001088</th>
                                    <td>MADHUSHAN A.K.D.T.</td>
                                </tr>
                                <tr>
                                    <th scope="row">20001101</th>
                                    <td>MANOHARAN K.</td>
                                </tr>
                                <tr>
                                    <th scope="row">20001126</th>
                                    <td>MATHANGADEERA D.D</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 colPadding">
                <form class="p-5 rounded shadow form" action="/config/auth.php" method="post" style="background-color:white;">
                    <h2 class="text-center">LOGIN</h2>
                    <div class="mb-3">
                        <label for="usr_name" class="form-label">User Name</label>
                        <input type="text" name="usr_name" class="form-control" id="usr_name" />
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Password</label>
                        <input type="password" name="pwd" class="form-control" id="pwd" />
                    </div>
                    <button type="submit" name="login" value="login" class="btn btn-primary">LOGIN</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>