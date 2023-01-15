<?php
//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $kodenya = $_POST['kodenya'];
    $stock = $_POST['stock'];

    $cekstocksekarang = mysqli_query($conn, "SELECT*FROM data_barang WHERE kode_barang='$kodenya'");
    $ambildata=mysqli_fetch_array($cekstocksekarang);

    $stocksekarang=$ambildata['stok'];
    $stockakhir=$stocksekarang+$stock;

    $addtomasuk = mysqli_query($conn,"INSERT INTO  barang_masuk (kode_barang,jumlah_barang_masuk) values ('$kodenya', '$stock')");
    $updatestockmasuk = mysqli_query($conn, " UPDATE data_barang set stok='$stockakhir' WHERE kode_barang='$kodenya'");

    if ($addtomasuk) {
        header('location:barang_masuk.php');
    }else{
        echo "Data gagal Ditambah";
        header('location:barang_masuk.php');
    }
}
?>