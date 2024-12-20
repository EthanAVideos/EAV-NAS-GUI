<!DOCTYPE html>
<html>
<head>
   <title>NAS GUI</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <style>
body {
 background-color: black;
 color: white;
}

.btn {
 background-color: #4CAF50; /* Green */
 color: white;
 padding: 15px 32px;
 text-align: center;
 text-decoration: none;
 display: inline-block;
 font-size: 16px;
 margin: 4px 2px;
 cursor: pointer;
 border-radius: 10px; /* Border Radius */
 transition-duration: 0.4s; /* Transition Effect */
}

.btn:hover {
 background-color: #45a049; /* Darker Green */
 transition-duration: 0.4s; /* Transition Effect */
}

input[type='file']::file-selector-button {
   background-color: #4CAF50; /* Green */
   color: white;
   border-radius: 10px; /* Border Radius */
   padding: 5px 10px; /* Padding */
   transition-duration: 0.4s; /* Transition Effect */
}

input[type='file']::file-selector-button:hover {
    background-color: #45a049; /* Darker Green */
    transition-duration: 0.4s; /* Transition Effect */
}


input[type=text], input[type=password] {
 width: 100%;
 padding: 12px 20px;
 margin: 8px 0;
 display: inline-block;
 border: 5px solid green;
 box-sizing: border-box;
 border-radius: 10px; /* Border Radius */
 background-color: gray;
 font-size: 15px;
}

hr {
    border-color: #4CAF50; /* Green */
}

a {

    color: #4CAF50; /* Green */
    margin: 5px;
    transition-duration: 0.4s; /* Transition Effect */
}

a:hover {
 color: #45a049; /* Darker Green */
 transition-duration: 0.4s; /* Transition Effect */
}

#main {
    width: 50%;
    border: 5px solid #4CAF50; /* Green */;
}

</style>
</head>
<body>


<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
function listFolderFiles($dir, $indent = '') {
    $ffs = scandir($dir);
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    if (count($ffs) < 1)
    return;
    echo '<ol>';
    foreach($ffs as $ff){
    echo '<li>' . $indent . $ff;
    if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff, $indent . '-');
    echo '<span>';
    if (!is_dir($dir.'/'.$ff)) {
    $ext = pathinfo($dir . '/' . $ff, PATHINFO_EXTENSION);
    switch ($ext) {
      case 'jpg':
      case 'jpeg':
      case 'png':
      case 'gif':
          echo '<a href="' . $dir . '/' . $ff . '" target="_blank"><i class="fa fa-picture-o"></i></a>';
          break;
      case 'mp4':
      case 'avi':
      case 'flv':
      case 'mkv':
          echo '<a href="' . $dir . '/' . $ff . '" target="_blank"><i class="fa fa-film"></i></a>';
          break;
      case 'txt':
      case 'docx':
      case 'xlsx':
      case 'pptx':
          echo '<a href="' . $dir . '/' . $ff . '" target="_blank"><i class="fa fa-file-text-o"></i></a>';
          break;
      default:
          echo '<a href="' . $dir . '/' . $ff . '" download><i class="fas fa-download"></i></a>';
          break;
    }
    echo '<a href="' . $dir . '/' . $ff . '" download><i class="fas fa-download"></i></a>';
    }
    echo '</span>';
    echo '</li>';
    }
    echo '</ol>';
   }
   
   $target_dir = './uploads/';
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
    $target_file = $target_dir . $_POST['newFolderName'] . '/' . basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
   
    if (!empty($_POST['newFolderName'])) {
    $parts = explode('/', trim($_POST['newFolderName'], '/'));
    $currentDir = $target_dir;
    foreach ($parts as $part) {
    $currentDir .= $part . '/';
    if (!file_exists($currentDir)) {
    mkdir($currentDir, 0777, true);
    }
    }
    }
   
    if (isset($_POST['delete'])) {
    $file = $target_dir . $_POST['delete'];
    if (is_file($file)) {
    unlink($file);
    } else if (is_dir($file)) {
    $iterator = new RecursiveDirectoryIterator($file, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
     if ($file->isDir()) {
       rmdir($file->getRealPath());
     } else {
       unlink($file->getRealPath());
     }
    }
    rmdir($file);
    }
    }
   }
   
   listFolderFiles($target_dir);
   ?>
   <center>
    <br>
    <hr>
    <br>
   <form action="" method="post" enctype="multipart/form-data">
    Upload to folder:
    <input type="text" name="newFolderName" placeholder="Enter path to upload to or create that path">
    <br>
    Select file to upload:
    <input type="file" name="fileToUpload">
    <br>
    <input class="btn" type="submit" value="Upload File or Create Folder">
   </form>
    <br>
    <hr>
    <br>
   <form method="post">
    Delete:
    <input type="text" name="delete" placeholder="Enter path here to delete">
    <input class="btn" type="submit" value="Delete">
   </form>
   <br><br>
   <div id="main">
        <h1>Welcome To Ethan's Netowrk Attached Storage System</h1><br>
        <br>
        <hr>
        <br>
        <h3>Server Administrators</h3>
        <h5>Ethan</h5>
        <br>
        <hr>
        <br>
        <h3>Instructions</h3><br>
        <h4>How To Create Folders</h4>
        <p>Go to "Upload to folder" bar & enter the name of the folder then click "Upload File or Create Folder" button to create a main folder.
        To a main & sub folder follow top steps but when naming the folder type the main folder name then add / then type the sub folder name (i.g main/sub) & adding a sub folder to a main folder that is alreadly there is the same way.<br></p>
        <h4>File Viewer</h4>
        <p>Anything that has just its name in the File Viewer</a> is a main folder & in the root folder sub folders & items will have an - before its name the deeper it is the more - it will have before it name (i.g image.png -image.png --image.png )<br>
         the <i class="fa fa-picture-o"></i> when click will open what its next to in a new tab to preview<br>
        the <i class="fas fa-download"></i> when click will download what its next to</p><br>
        <h4>How To Upload</h4>
        <p>Go to the "Upload to folder" bar & enter the path where you want to upload to if lefted empty it will upload to the root folder.<br>
            Choose what to upload by clicking the "Browse" button then once your readly to upload click the "Upload File or Create Folder" button.<br>
            <b>Upload Restrictions</b> <br>
            Only the following file extensions can be uploaded: JPG, JPEG, PNG, GIF, MP4, AVI, FLV, MKV, TXT, DOCX, XLSX, PPTX, ZIP<br>
            No Upload Size Limit.
        </p><br>
        <h4>How To Delete Content & Folder </h4>
        <p>Go to the "Delete" bar & type in the path of what you want to delete & then click the "Delete" button (i.g main/sub/image.png , main/sub) here we are deleting an image in a sub folder then we are deleting a sub folder<br>
        (If you delete a folder you must refresh the page to take effect)<br><br>
        <b>Do Not Ever Delete The Root Folder (This will break the file, upload, deletion, GUI system)</b></p>

   </div>
</center>
<script>
    console.warn("YOU ARE NOT TO BE VIEWING THE CODE OR PROCESS!!!");
    console.log("version:1.1.0 main-theme:hard-green sub-theme:none ; 1-1-24 @ 7:08:16 am");
    console.warn("YOU ARE NOT TO BE VIEWING THE CODE OR PROCESS!!!");
</script>
   </body>
</html>