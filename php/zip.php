<?php
$zipName = $_POST["name"];
$fileNames = array();
$compressionLevel = $_POST["compress"];
if (isset($compressionLevel) and $compressionLevel == "deflate") {
    $compress = ZipArchive::CM_DEFLATE;
} else {
    $compress = ZipArchive::CM_STORE;
}
$dirname = uniqid();
$destination = "../userUploads/" . $zipName . $dirname;
mkdir($destination);
if (isset($_POST['submit'])) {
    // Count total files
    $countfiles = count($_FILES['file']['name']);
    // Looping all files
    for ($i = 0; $i < $countfiles; $i++) {
        $filename = $_FILES['file']['name'][$i];
        //Save FileNames for zipping later
        $fileNames[] = $destination . "/" . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $destination . "/" . $filename)) {
            //            echo "Uploaded Successfully<br>";
        } else {
            //            echo "FAILED<br>";
        }
    }
    //ZIP Creation
    $zip = new ZipArchive;
    if ($zip->open($destination . "/" . $zipName . '.zip', ZipArchive::CREATE) === TRUE) {
        // Add a file new.txt file to zip using the text specified
        $zip->setCompressionIndex(0, $compress);
        for ($i = 0; $i < $countfiles; $i++) {
            if ($zip->addFile($fileNames[$i], basename($fileNames[$i])) === TRUE)
                $zip->setCompressionIndex($i + 1, $compress);
        }
        // All files are added, so close the zip file.
        $zip->close();
    }
    $downloadLink = "../userUploads/" . $zipName . $dirname . "/" . $zipName . '.zip';
    header('Location: ' . $downloadLink);
    echo "<script type='text/javascript'>window.close();</script>";
}
