<?php
    require('functions.php');
    # KODE INI UNTUK MENCEGAH USER PAKSA DIRECT KE CRUD #

    session_start();
    if(!isset($_SESSION['userLogin']) || $_SESSION['userLogin'] == ""){
        header("Location: index.php");
    }
?>

<?php 
    if(isset($_GET)){
        $id = $_GET['id'];
        $sql = "SELECT * FROM olahraga WHERE id_olahraga = '$id' LIMIT 1";
        $result = mysqli_query($conn,$sql);
        $hasil = mysqli_fetch_assoc($result);

        // if(mysqli_num_rows($result)>0){
        //     $row = mysqli_fetch_assoc($result);
        //     print_r($row);
        // }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sehat Dulu | Edit</title>
    <link rel="stylesheet" href="css/styleAdd.css">
    <link rel="shortcut icon" href="images/logo-title.png" type="image/x-icon">
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
            <form action="edit.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>Nama Olahraga </td>
                    <td><input type="text" name="nama_olahraga" class="form-text" value= "<?= $hasil["nama_olahraga"] ?>"></td>
                </tr>
                
                <tr>
                    <td>Durasi</td>
                    <td><input type="text" name="durasi" class="form-text" value= "<?= $hasil["durasi"] ?>"></td>
                </tr>

                <tr>
                    <td>Tipe Olahraga</td>
                    <td>
                        <select name="comboTipe" selected= "<?= $hasil["id_tipe"] ?>">
                        <option selected disabled hidden>Pilih Tipe Olahraga</option>
                            <?php
                                $query = "SELECT * FROM tipe_olahraga";
                                $result = mysqli_query($conn,$query);
                                $counter1 = 1;
                                
                                while($row = mysqli_fetch_assoc($result)){
                                    if(intval($hasil["id_tipe"]) == $counter1){
                                        echo "<option selected value = '". $row['id_tipe']. "'>". $row['tipe_olahraga'] . "</option>";
                                    }else{
                                        echo "<option value = '". $row['id_tipe']. "'>". $row['tipe_olahraga']. "</option>";
                                    }
                                    $counter1 += 1;
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Tingkat Kesulitan</td>
                    <td>
                        <select name="comboKesulitan" selected= "<?= $hasil["id_kesulitan"] ?>">
                        <option selected hidden disabled>Pilih Tingkat Kesulitan</option>
                            <?php
                                $query = "SELECT * FROM kesulitan";
                                $result = mysqli_query($conn,$query);

                                $counter2 = 1;
                                while($row = mysqli_fetch_assoc($result)){
                                    if(intval(intval($hasil["id_kesulitan"])) == $counter2){
                                        echo "<option selected value = '". $row['id_kesulitan']. "'>". $row['tingkat_kesulitan']. "</option>";
                                    }else{
                                        echo "<option value = '". $row['id_kesulitan']. "'>". $row['tingkat_kesulitan']. "</option>";
                                    }
                                    $counter2+=1;
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Instruktur</td>
                    <td>
                        <select name="comboInstruktur">
                        <option selected hidden disabled>Pilih Instruktur</option>
                            <?php
                                $query = "SELECT * FROM instruktur";
                                $result = mysqli_query($conn,$query);

                                $counter3 = 1;
                                while($row = mysqli_fetch_assoc($result)){
                                    if(intval(intval($hasil["id_instruktur"])) == $counter2){
                                        echo "<option selected value = '". $row['id_instruktur']. "'>". $row['nama_instruktur']. "</option>";
                                    }else{
                                        echo "<option value = '". $row['id_instruktur']. "'>". $row['nama_instruktur']. "</option>";
                                    }
                                    $counter3+=1;
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Peralatan</td>
                    <td>
                        <?php
                            $query = "SELECT * FROM peralatan";
                            $result = mysqli_query($conn,$query);
                            $resultDetailPeralatan = mysqli_query($conn,"SELECT id_alat FROM detail_peralatan WHERE id_olahraga = ". $hasil['id_olahraga']."");
                            $hasilDetPer = mysqli_fetch_assoc($resultDetailPeralatan); // hasildetailperalatan

                            while($row = mysqli_fetch_assoc($result)){
                                // echo "<input type='checkbox' name='comboAlat[]' value= '". $row['id_peralatan']. "'>". $row['nama_peralatan']."</input>";
                                echo "<input type='checkbox' name='comboAlat[]' value= '". $row['id_peralatan']."' ". ($hasilDetPer['id_alat'] == $row['id_peralatan'] ? 'checked' : '') .">". $row['nama_peralatan']."</input>";
                                
                            }
                            echo "<br>";
                            print_r($hasilDetPer);
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>Deskripsi</td>
                    <td><textarea name="deskripsi" class="form-textarea"><?= $hasil["deskripsi"] ?></textarea></td>
                </tr>

                <tr>
                    <td>Langkah</td>
                    <td><textarea name="step" class="form-textarea"><?= $hasil["step"] ?></textarea></td>
                </tr>

                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="gambar" accept="image/png, image/jpeg"></td>
                </tr>

                <tr>
                    <td>Link Video</td>
                    <td><input type="text" name="video" class="form-text" value= "<?= $hasil["video"] ?>"></td>
                </tr>

                <tr>
                    <td><a href="crud.php"><< Back</a></td>
                    <td><input type="submit" name = "submit" value="Submit"></td>
                </tr>
            </form>
        </div>
    </table>

</body>
<script src="edit.js"></script>
</html>