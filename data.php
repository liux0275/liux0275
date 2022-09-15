<?php
function readCart() {
  try {
    $conn = conDB();
    $stmt = $conn->prepare("SELECT Shop.Name,Shop.Price,Cart.Qty,Cart.ID FROM Cart JOIN Shop ON Cart.ItemID=Shop.ItemID WHERE UID = ?");
    $stmt->execute([$_SESSION["uid"]]);
    $data = $stmt->fetchAll();

    $tt = 0;

    echo '<form method="post">';
    echo '<table class="cart">';
    echo '<tr> <td><h2>Item</h2></td> <td><h2>Price</h2></td> <td><h2>Quantity</h2></td> <td><h2>Total</h2></td> <td></td> </tr>';
    foreach ($data as $row) {
      echo "<tr><td>" . $row["Name"] . "</td>";
      echo "<td>$" . $row["Price"] . "</td>";
      echo "<td>" . '<input type="number" value="' . $row["Qty"] . '" name="' . $row["ID"] . '" required>' . '<button type="submit" name="update" value="' . $row["ID"] . '">Update</button>' . "</td>";
      echo "<td>$" . $row["Price"]*$row["Qty"] . "</td>";
      $tt += $row["Price"]*$row["Qty"];
      echo '<td><button type="submit" name="removeCart" value="' . $row["ID"] . '">Remove</button></td></tr>';
    }
    echo "<tr><td></td><td></td><td></td><td>$" . $tt . "</td></tr>";
    echo "</table>";
    echo "</form>";
    $conn = null;
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function shopList() {
  try {
    $conn = conDB();
    $stmt = $conn->prepare("SELECT * FROM Shop");
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    echo '<div id="overlay">';
    echo '<form method="post">';
    echo '<table class="shop">';
    echo '<tr> <td><h2>Item</h2></td> <td><h2>Price</h2></td> <td><h2>Quantity</h2></td> <td></td> </tr>';
    foreach ($data as $row) {
      echo "<tr><td>" . $row["Name"] . "</td>";
      echo "<td>$" . $row["Price"] . "</td>";
      echo "<td>" . '<input type="number" value=1 name="' . $row["ItemID"] . '" required>' . "</td>";
      echo "<td>" . '<button type="submit" name="addToCart" value="' . $row["ItemID"] . '">Add to cart</button>' . "</td></tr>";
    }
    echo "<tr><td></td><td></td><td></td><td>" . '<button type="button" onclick="closeShop()">Close</button>' . "</td></tr>";
    echo "</table>";
    echo "</form>";
    echo "</div>";

    $conn = null;
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function updateCart($CartID,$Qty) {
  try {
    $conn = conDB();
    $stmt = $conn->prepare("UPDATE Cart SET Qty = ? WHERE ID = ?");
    if ($stmt->execute([$Qty,$CartID])) {
      echo '<script>document.location.href = "cart.php";</script>';
    }else{
      echo '<script>alert("Something went wrong, please try again");</script>';
    }
    $conn = null;
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function addCart($itemID,$Qty) {
  if ($_SESSION["uid"] != null) {
    try {
      $conn = conDB();
      $stmt = $conn->prepare('INSERT INTO Cart (UID,ItemID,Qty) VALUES(?,?,?)');
      if ($stmt->execute([$_SESSION["uid"],$itemID,$Qty])) {
        echo '<script>document.location.href = "cart.php";</script>';
      }else{
        echo '<script>alert("Something went wrong, please try again");</script>';
      }
      $conn = null;
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }else{
    echo '<script>alert("Session expired, please login again.");document.location.href = "index.php";</script>';
  }
}

function delCart($id) {
  if ($_SESSION["uid"] != null) {
    try {
      $conn = conDB();
      $stmt = $conn->prepare('DELETE FROM Cart WHERE ID = ?');
      if ($stmt->execute([$id])) {
        echo '<script>document.location.href = "cart.php";</script>';
      }else{
        echo '<script>alert("Something went wrong, please try again");</script>';
      }
      $conn = null;
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }else{
    echo '<script>alert("Session expired, please login again.");document.location.href = "index.php";</script>';
  }
}
?>
