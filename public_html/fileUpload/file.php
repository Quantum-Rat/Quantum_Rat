<?php

    if(isset($_POST["fileSubmit"])) {
        $file = $_FILES["fileUpload"];

        $fileName = $file["name"];
        $fileTmp = $file["tmp_name"];

        $path = "./files/";
        $dest = $path.$fileName;

        if(move_uploaded_file($fileTmp, $dest)) {
            $jsonRead = fopen("fileOrders.json", "r");
            $jsonSize = filesize("fileOrders.json");

            $jsonDecode = json_decode(fread($jsonRead, $jsonSize), true);
            fclose($jsonRead);

            if(count($jsonDecode["lastFiles"]) != 5) {
                array_push($jsonDecode["lastFiles"], $fileName);
            }
            else {
                // $removeFile = $jsonDecode["lastFiles"][0];
                // $removeFilePath = $path.$removeFile;
                // unlink($removeFilePath);

                array_splice($jsonDecode["lastFiles"], 0, 1);
                array_push($jsonDecode["lastFiles"], $fileName);
            }

            $jsonEncode = json_encode($jsonDecode, JSON_PRETTY_PRINT);
            $jsonWrite = fopen("fileOrders.json", "w");
            fwrite($jsonWrite, $jsonEncode);
            fclose($jsonWrite);
            header("Location: file.php");
        }
        else {
            header("Location: error.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v=1.6">
</head>
<body>

    <header class="header">
        <div class="header-side header-section header-left">

        </div>

        <div class="header-center">
            <div class="header-center-logo-container header-section">
                <img src="quantum.png" alt="logo" height="100%" class="header-center-logo">
            </div>

            <div class="header-center-text-container header-section">
                <span class="header-center-text">Quantum</span>
            </div>
        </div>

        <div class="header-side header-section header-right">

        </div>
    </header>

    <form action="" method="POST" class="container" enctype="multipart/form-data">

        <div class="file-container">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div class="file-content">
                
                <div class="file-content2">
                    <div class="file-icon">
                        <img src="fileicon.png" alt="" height="300px" class="file-img">
                    </div>
                    <div class="file-name-container">
                        <div class="file-name">Filename.exe</div>
                    </div>
                </div>
            </div>

            <input type="file" class="file-upload-input" name="fileUpload">
        </div>

        <div class="buttons">
            
            <button type="submit" class="btn" name="fileSubmit">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Upload
            </button>

            
            <div class="btn-container">

                <div class="btn">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Download
                </div>

                <div class="btn-menu">
                    <?php
                        $jsonRead = fopen("fileOrders.json", "r");
                        $jsonSize = filesize("fileOrders.json");

                        $jsonDecode = json_decode(fread($jsonRead, $jsonSize), true);
                        fclose($jsonRead);
                        // print_r($jsonDecode["lastFiles"][1]);
                    ?>
                    <?php foreach($jsonDecode["lastFiles"] as $file): ?>
                    
                        <a href="./files/<?php echo $file ?>" class="btn-menu-link" download><?php echo $file ?></a>
                        
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

    </form>

    


    <script src="script.js"></script>
</body>
</html>