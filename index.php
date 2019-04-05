<?php

  //error handling function
  function exit_and_redirect($message)
  {
        header("Location: index.php?msg=$message");
        exit();
  }

  //getting image
  $image_name = isset( $_POST['submit'] ) ? $_FILES['image']['name'] : false;

  //checking if image uploaded
  if($image_name){

      //temporary current location of image
      $image_temporary_location  = $_FILES['image']['tmp_name'];

      //image size and validation
      $image_size = $_FILES['image']['size'];

      if( $image_size >= 20000000 ){
          exit_and_redirect('Image Size must Be less than 20MB');
      }

      //image extension and validation
      $image_extension = strtolower( pathinfo($image_name, PATHINFO_EXTENSION) );

      $valid_extensions = [ 'jpg', 'png', 'jpeg', 'gif' ];

      if ( ! in_array( $image_extension, $valid_extensions ) ) {
            exit_and_redirect('Invalid Image Extension');
      }

      //final name of image
      $final_image_name = "xyz.png";

      //upload dir
      $upload_directory = 'image/';

      //final location of image
      $image_final_location = $upload_directory.$final_image_name;

      if( move_uploaded_file( $image_temporary_location, $image_final_location ) ){
            exec('python3 python.py');
            echo<<<HTML
            <a href="output.txt" download>Download Text File here</a>
HTML;
      }else{
        exit_and_redirect('Invalid Permission on Directory, use sudo chmod 777 on whole directory ');
      }

 }

?>

Smart Attendance Image Upload : <br>

<?php
      if ( isset($_GET['msg']) ){
          echo '<b>Error :</b>'. htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8') .'<br>';
      }
?>

<form method="post" enctype="multipart/form-data" action="index.php"><br>
  <input type="file" accept="image/*" name="image"><br>
  <input type="submit" name="submit" value="Upload">
</form>
