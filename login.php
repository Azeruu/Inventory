<?php
require 'koneksi.php';

//cek login
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //cek keberadaan di database
    $cekdbase = mysqli_query($conn,"SELECT*FROM tb_login WHERE email='$email' and password='$password'");

    //menghitung jumlah data
    $hitung = mysqli_num_rows($cekdbase);

    if($hitung>0){
        $_SESSION['log']='true';
        header('location:index.php');
    }else{
        header('location:login.php');
    };
};

if (!isset($_SESSION['log'])) {
    # code...
}else {
    header('location:index.php');   
};


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary" background="wp1.jpg">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <p>Email</p>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Masukan Email address</label>
                                            </div>
                                            <p>Password</p>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Masukan Password</label>
                                            </div>
                                            <div >
                                                <button class="btn btn-primary"  name="login" >Login</button> atau <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#myModal">Daftar</button></div><br>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
     <!-- Modal Daftar -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Akun</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
        <form method="post">
            <div class="modal-body">
                Email 
                <input type="text" name="email" placeholder="Masukan Email" class="form-control" required><br>Password
                <input type="text" name="password" placeholder="Masukan Password" class="form-control" required><br>
                <button type="submit" name="daftar" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>
</html>
