

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Bootstrap</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row border w-100 shadow rounded">
        <div class="col-md-5 bg-primary d-flex justify-content-center align-items-center mydiv shadow rounded">
            <h1 class="text-center text-white text-effect">Pharmacy</h1>
        </div>
        <div class="col-md-7">
            <form class="row justify-content-center mt-5" method="POST" action="authenticate.php">
                <div class="col-10 col-md-8">
                    <h1 class="text-center mb-4 text-effect">Login</h1>
                    <p class="text-center mb-5">Access to our dashboard</p>
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" id="email" name="username" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <a href="#" class="mt-3 mb-5 d-block text-center"></a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
