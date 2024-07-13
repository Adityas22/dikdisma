<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DIKPORA SEKSI-SMA</title>
    <link rel="icon" href="img/dikpora.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>

    <div class="background-pattern"></div>
    <div class="content">
        <div class="info">
            <h1>Register</h1>
            <div class="form-container">
                <a href="#" class="trial-button">Try it free 7 days then $20/mo. thereafter</a>
                <form action="register_proses.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" class="form-control" id="password" placeholder="password"
                            name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>