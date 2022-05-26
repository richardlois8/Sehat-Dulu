<?php
    require('functions.php');
    // # KODE INI UNTUK MENCEGAH USER PAKSA DIRECT KE CRUD #

    // session_start();
    // if(!isset($_SESSION['userLogin']) || $_SESSION['userLogin'] == ""){
    //     header("Location: index.php");
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styleAdd.css">
</head>
<body>
    <header>
        <div class="header-left">
            <img class="logo" src="images/logo-white.png" alt="logo">
        </div>
        <div class="header-right">
            <a href="index.php">Beranda</a>
            <a href="latihan.php">Latihan</a>
            <a href="kontak.php">Kontak</a>
            <a href="index.php">Logout</a>
        </div>
    </header>
    <table>
        <div class="form-wrapper">
            <form action="add.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>Nama Olahraga </td>
                    <td><input type="text" name="nama_olahraga" class="form-text"></td>
                </tr>
                <tr>
                    <td>Durasi</td>
                    <td><input type="text" name="durasi" class="form-text"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><textarea name="deskripsi" class="form-textarea"></textarea></td>
                </tr>
                <tr>
                    <td>Link Video</td>
                    <td><input type="text" name="video" class="form-text"></td>
                </tr>
                <tr>
                    <td>Tipe Olahraga</td>
                    <td>
                        <select name="comboTipe">
                        <option value="">Pilih Tipe Olahraga</option>
                            <?php
                                $query = "SELECT * FROM tipe_olahraga ORDER BY tipe_olahraga ASC";
                                $result = mysqli_query($conn,$query);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value = '". $row['id_tipe']. "'>". $row['tipe_olahraga']. "</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tipe Kesulitan</td>
                    <td>
                        <select name="comboKesulitan">
                        <option value="">Pilih Tingkat Kesulitan</option>
                            <?php
                                $query = "SELECT * FROM kesulitan";
                                $result = mysqli_query($conn,$query);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value = '". $row['id_kesulitan']. "'>". $row['tingkat_kesulitan']. "</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="gambar"></td>
                </tr>
                
                <tr>
                    <td>Langkah</td>
                    <td><textarea name="step" class="form-textarea"></textarea></td>
                </tr>
                <tr>
                    <td><a href="crud.php"><< Back</a></td>
                    <td><input type="submit" name = "submit" value="Submit"></td>
                </tr>
            </form>
        </div>
    </table>

</body>
</html>

<?php


    if(isset($_POST['submit'])){
        $olahraga = $_POST['nama_olahraga'];
        $durasi = $_POST['durasi'];
        $desc = $_POST['deskripsi'];
        $vid = $_POST['video'];
        $tipe = $_POST['comboTipe'];
        $kesulitan = $_POST['comboKesulitan'];
        $gambar = "";
        $step = $_POST['step'];

        if(isset($_FILES["gambar"]["name"])){
            $ekstensi = explode(".",$_FILES["gambar"]["name"]);
            $gambar = $olahraga . "." . $ekstensi[1];
            
            $uploadfile = "images/workout/" . $gambar;
            if(move_uploaded_file($_FILES["gambar"]["tmp_name"], $uploadfile)){
                echo "Sukses mengupload foto<br>";
            }else{
                echo "Gagal mengupload foto<br>";
            }
        }

        $sql = "INSERT INTO olahraga VALUES ('','$olahraga',$durasi,'$desc','$vid',$tipe,$kesulitan,'$gambar','$step')";
        
        if(mysqli_query($conn,$sql)){
            echo "Berhasil menambahkan data<br>";
        }else{
            echo "Gagal menambahkan data<br>";
        }
    }
?>