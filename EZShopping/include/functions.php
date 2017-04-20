<?php include "dblink.php"; ?>
<?php
	function showCarts(){
		global $link;
		$sql = "SELECT cart.*, products.pro_name, products.price FROM cart
			LEFT JOIN products
			ON cart.pro_id = products.pro_id
			WHERE session_id = '$sid'";
$result = mysqli_query($link, $sql);
$num_items =  mysqli_num_rows($result);
		$grand_total = 0;
while($cart = mysqli_fetch_array($result)) {
	//แทนที่ ","ด้วย <br> เพื่อแยกแต่ละคุณลักษณะไว้คนละบรรทัด
	$attr = preg_replace("/,/", "<br>", $cart['attribute']);
	$price = number_format($cart['price']);
	$sub_total = number_format($cart['quantity'] * $cart['price']);
	echo "<tr>";
	echo "<td>{$cart['pro_name']}</td>";
	echo "<td>$attr</td>";
	echo '<td><input type="number" name="quantity" min="1" value="'. $cart['quantity'] . '"></td>';
	echo "<td>$price</td>";
	echo "<td>$sub_total</td>";
	echo '<td>
					<button class="save-change" data-id="' . $cart['item_id'] . '">บันทึก</button>
					<button class="delete" data-id="' . $cart['item_id'] . '">ลบ</button>
			</td>';
	$grand_total += $cart['quantity'] * $cart['price'];
}
	}
?>

