<?php
function auth() {
  try {
    $conn = conDB();
    $stmt = $conn->prepare("SELECT Password FROM User WHERE UID = ? LIMIT 1");
    $stmt->execute([$_POST["uid"]]);
    $pw = $stmt->fetch();
    if ($pw != null) {
      if ($pw["Password"] == $_POST["pw"]) {
        $_SESSION["uid"] = $_POST["uid"];
        unset($_POST);
        echo '<script>document.location.href = "cart.php";</script>';
      }else{
        echo '<script>alert("Wrong password"); document.location.href = "index.php";</script>';
      }
    }else{
      echo '<script>alert("Wrong username"); document.location.href = "index.php";</script>';
    }
    
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  
  $conn = null;
}

function changePw($pw) {
  if ($_SESSION["uid"] != null and $pw != null) {
    $conn = conDB();
    $stmt = $conn->prepare("UPDATE User SET Password = ? WHERE UID = ?");
    if ($stmt->execute([$pw,$_SESSION["uid"]])) {
      echo '<script>alert("Password Changed");</script>';
    }else{
      echo '<script>alert("Something wrong, please try again");</script>';
    }
  }else{
    echo '<script>alert("Session expired, please login again.");document.location.href = "index.php";</script>';
  }

}

?>
