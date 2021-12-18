<?php
$target_dir = "../rapports/";
$q= "SELECT ID FROM DEMANDE WHERE CNE_ETUDIANT=:cne_etudiant AND ETAT_DEMANDE=1";
$res = $pdo->prepare($q);
$res->execute(array('cne_etudiant' => $etudiant->cne));
$data = $res->fetch();
$target_file = $target_dir . $etudiant->cne . "_" . $data["ID"] . ".pdf";
$uploadOk = 1;
$fileType = strtolower(pathinfo($_FILES["rapport"]["name"],PATHINFO_EXTENSION));
// Check if file already exists
$upload_error = "";
$upload_info = "";
if (file_exists($target_file)) {
    $upload_error =  "Vous avez déjà envoyer un rapport." . $upload_error;
    $uploadOk = 0;
}


// Allow certain file formats
if($fileType != "pdf") {
  $upload_error = "Sorry, only PDF files are allowed. " . $upload_error;
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $upload_error = "Sorry, your file was not uploaded. " . $upload_error;
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["rapport"]["tmp_name"], $target_file)) {
      $upload_info =  "The file ". htmlspecialchars( basename( $_FILES["rapport"]["name"])). " has been uploaded. " . $upload_info;
      $q = "INSERT INTO RAPPORT(id_demande) SELECT ID FROM DEMANDE WHERE CNE_ETUDIANT=:cne_etudiant AND ETAT_DEMANDE=1";
      $res = $pdo->prepare($q);
      $res->execute(array('cne_etudiant' => $etudiant->cne));
      $q = "UPDATE `rapport` SET `filename`=:filenamee WHERE `id` = LAST_INSERT_ID()";
      $res = $pdo->prepare($q);
      $res->execute(array('filenamee' => $etudiant->cne . "_" . $data["ID"] ));
    } else {
      $upload_error = "Sorry, there was an error uploading your file. " . $upload_error;
    }
  }
?>