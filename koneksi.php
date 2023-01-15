<?php
session_start();
//koneksi ke database
$conn=mysqli_connect("localhost","root","","db_inventory") or die ("database tidak berhasil terkoneksi");

//menambah barang baru
if(isset($_POST['tambahbarang'])){
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $hargasatuan = $_POST['hargasatuan'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"INSERT INTO  data_barang (kode_barang, nama_barang, harga_satuan, stok) values ('$kodebarang', '$namabarang', '$hargasatuan', '$stock')");
    if ($addtotable) {
        header('location:stok_barang.php');
    }else{
        echo "Data gagal Ditambah";
        header('location:stok_barang.php');
    }
}

//menambah barang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $kodenya = $_POST['kodenya'];
    $stock = $_POST['stock'];

    $cekstocksekarang = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$barangnya'");
    $ambildata=mysqli_fetch_array($cekstocksekarang);

    $stocksekarang=$ambildata['stok'];

    if($stocksekarang>=$stock){
        //Kalau Barang Cukup
    $stockakhir=$stocksekarang-$stock;

    $addtokeluar = mysqli_query($conn,"INSERT INTO  barang_keluar (kode_barang, nama_barang_keluar,stok_barang_keluar) values ('$barangnya', '$kodenya', '$stock')");
    $updatestockkeluar = mysqli_query($conn, " UPDATE data_barang set stok='$stockakhir' WHERE kode_barang='$barangnya'");

    if ($addtokeluar) {
        header('location:barang_keluar.php');
    }else{
        echo "Data gagal Ditambah";
        header('location:barang_keluar.php');
    }
}else{
    //Kalau Barangnya Gak Cukup
    echo'
        <script>
            alert("Stok Saat Ini Tidak mencukupi");
            window.location.href="barang_keluar.php";
        </script>
        ';
}
}

//Update Info Barang di Tabel data_barang
if(isset($_POST['updatebarang'])){
    $namabarang = $_POST['namabarang'];
    $kodebarang = $_POST['kodebarang'];
    $hargasatuan = $_POST['hargasatuan'];

    $updatebarang = mysqli_query($conn,"UPDATE data_barang SET kode_barang='$kodebarang', nama_barang='$namabarang', harga_satuan='$hargasatuan' WHERE kode_barang='$kodebarang'");

    if ($updatebarang) {
        header('location:stok_barang.php');
    }else{
        echo "Data gagal Ditambah";
        header('location:stok_barang.php');
    }
}
//Delete Barang di Tabel data_barang
if(isset($_POST['hapusbarang'])){
    $kodebarang = $_POST['kodebarang'];

    $hapusbarang = mysqli_query($conn,"DELETE FROM data_barang WHERE kode_barang='$kodebarang'");

    if ($hapusbarang) {
        header('location:stok_barang.php');
    }else{
        echo "Data gagal Ditambah";
        header('location:stok_barang.php');
    }
}

//Mengubah Data Barang Masuk 
if(isset($_POST['updatebarangmasuk'])){
    $namabarang = $_POST['namabarang'];
    $kodebarang = $_POST['kodebarang'];
    $kodebarangmasuk = $_POST['kodebarangmasuk'];
    $stok = $_POST['stokmasuk'];

    //ambil data stok dari tabel data_barang
    $lihatstock = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$kodebarang'");
    $stocknya=mysqli_fetch_array($lihatstock);
    $stockskrg=$stocknya['stok'];

    //ambil data stok dari tabel barang_masuk
    $lihatqty = mysqli_query($conn, "SELECT*FROM barang_masuk WHERE kode_barang_masuk='$kodebarangmasuk'");
    $qtynya=mysqli_fetch_array($lihatqty);
    $qtyskrg=$qtynya['stok_barang_masuk'];

        $selisih = $stockskrg - $qtyskrg;
        $tambahin = $stok + $selisih;
        $kuranginstocknya = mysqli_query($conn, "UPDATE data_barang SET stok='$tambahin' WHERE kode_barang='$kodebarang'");
        $updatenya = mysqli_query($conn, "UPDATE barang_masuk SET stok_barang_masuk = '$stok' WHERE kode_barang_masuk='$kodebarangmasuk'");
            if ($kuranginstocknya&&$updatenya) {
                header('location:barang_masuk.php');
            }else{
                echo "Data gagal Ditambah";
                header('location:barang_masuk.php');
            }
    
}

//Menghapus Data Barang Masuk
if(isset($_POST['hapusbarangmasuk'])){
    $namabarang = $_POST['namabarang'];
    $kodebarang = $_POST['kodebarang'];
    $kodebarangmasuk = $_POST['kodebarangmasuk'];
    $stok = $_POST['stokmasuk'];

    //ambil data stok dari tabel data_barang
    $lihatstock = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$kodebarang'");
    $stocknya=mysqli_fetch_array($lihatstock);
    $stockskrg=$stocknya['stok'];

    //ambil data stok dari tabel barang_masuk
    $lihatqty = mysqli_query($conn, "SELECT*FROM barang_masuk WHERE kode_barang_masuk='$kodebarangmasuk'");
    $qtynya=mysqli_fetch_array($lihatqty);
    $qtyskrg=$qtynya['stok_barang_masuk'];

        $updatestock = $stockskrg - $qtyskrg;
        $kuranginstocknya = mysqli_query($conn, "UPDATE data_barang SET stok='$updatestock' WHERE kode_barang='$kodebarang'");
        $hapusnya = mysqli_query($conn, "DELETE FROM barang_masuk WHERE kode_barang_masuk='$kodebarangmasuk'");
            if ($kuranginstocknya&&$hapusnya) {
                header('location:barang_masuk.php');
            }else{
                echo "Data gagal Ditambah";
                header('location:barang_masuk.php');
            }
    
}

//Mengubah Data Barang Keluar
if(isset($_POST['updatebarangkeluar'])){
    $namabarang = $_POST['namabarang'];
    $kodebarang = $_POST['kodebarang'];
    $kodebarangkeluar = $_POST['kodebarangkeluar'];
    $stok = $_POST['stokkeluar'];

    //ambil data stok dari tabel data_barang
    $lihatstock = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$kodebarang'");
    $stockkeluarnya=mysqli_fetch_array($lihatstock);
    $stockkeluarskrg=$stockkeluarnya['stok'];

    //ambil data stok dari tabel barang_keluar
    $lihatqtynya = mysqli_query($conn, "SELECT*FROM barang_keluar WHERE kode_barang_keluar='$kodebarangkeluar'");
    $qtykeluarnya=mysqli_fetch_array($lihatqtynya);
    $qtykeluarskrg=$qtykeluarnya['stok_barang_keluar'];

        $selisihkeluar = $stockkeluarskrg + $qtykeluarskrg;
        $kurangin = $selisihkeluar-$stok;
        $akhirstocknya = mysqli_query($conn, "UPDATE data_barang SET stok='$kurangin' WHERE kode_barang='$kodebarang'");
        $updatekeluarnya= mysqli_query($conn, "UPDATE barang_keluar SET stok_barang_keluar = '$stok' WHERE kode_barang_keluar='$kodebarangkeluar'");
            if ($akhirstocknya&&$updatekeluarnya) {
                header('location:barang_keluar.php');
            }else{
                echo "Data gagal Ditambah";
                header('location:barang_keluar.php');
            }
    
}

//Menghapus Data Barang Keluar
if(isset($_POST['hapusbarangkeluar'])){
    $namabarang = $_POST['namabarang'];
    $kodebarang = $_POST['kodebarang'];
    $kodebarangkeluar = $_POST['kodebarangkeluar'];
    $stok = $_POST['stokkeluar'];

    //ambil data stok dari tabel data_barang
    $lihatstock = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$kodebarang'");
    $stocknya=mysqli_fetch_array($lihatstock);
    $stockskrg=$stocknya['stok'];

    //ambil data stok dari tabel barang_keluar
    $lihatqty = mysqli_query($conn, "SELECT*FROM barang_keluar WHERE kode_barang_keluar='$kodebarangkeluar'");
    $qtynya=mysqli_fetch_array($lihatqty);
    $qtyskrg=$qtynya['stok_barang_keluar'];

        $updatestock = $stockskrg + $qtyskrg;
        $kuranginstocknya = mysqli_query($conn, "UPDATE data_barang SET stok='$updatestock' WHERE kode_barang='$kodebarang'");
        $hapusnya = mysqli_query($conn, "DELETE FROM barang_keluar WHERE kode_barang_keluar='$kodebarangkeluar'");
            if ($kuranginstocknya&&$hapusnya) {
                header('location:barang_keluar.php');
            }else{
                echo "Data gagal Ditambah";
                header('location:barang_keluar.php');
            }
    
}
//Daftar akun
if(isset($_POST['daftar'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //cek keberadaan di database
    $cekdbase = mysqli_query($conn,"SELECT*FROM tb_login WHERE email='$email' and password='$password'");
    $cekall = mysqli_num_rows($cekdbase);

    //insert data akun baru
    $insakun = mysqli_query($conn,"INSERT INTO tb_login (email,password)value('$email','$password')");

    if($cekall>0){
        echo'
        <script>
            alert("Akun Sudah Terdaftar, Cari nama lain");
            window.location.href="login.php";
        </script>
        ';
        
    }else{
        $insakun;
        echo'
        <script>
            alert("Akun Berhasil Terdaftar");
            window.location.href="login.php";
        </script>
        ';
    };
};

?>