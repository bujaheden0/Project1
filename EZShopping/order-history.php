<?php include "include/header.php" ?>
<style>
	
	input.receive {
		width:100px;
	}
	h2.warning {
		text-align: left !important;
	}
	span#forget-pswd {
		width: 425px;
		display: block;
		text-align: right;
		margin: -5px 0px 10px 0px;
	}
	span#forget-pswd a {
		font-size: 12px;
	}
	#head {
		padding: 5px !important;
	}
	table {
		margin: 20px auto;
		border-collapse: collapse;
	}
	caption {
		text-align: left;
		padding-bottom: 3px !important;
	}
	td:nth-child(1) {
		width: 230px;
		text-align: left !important;
	}
	td:nth-child(2) {
		width: 70px;
		
	}
	td:nth-child(3), td:nth-child(4) {
		width: 70px;
	}
	td:nth-child(5), td[colspan]+td {
		width: 100px;
	}
	td:nth-child(6) {
		width: 100px;	
	}
	td:nth-child(7) {
		width: 200px;

	}
	table th {
		background: green;
		color: black;
		padding: 5px;
		border-right: solid 1px white;
		font-size:12px;
		text-align: center;
	}
	tr:nth-of-type(odd) {
		background: lavender;
	}
	tr:nth-of-type(even) {
		background: whitesmoke;
	}
	td {
		text-align: center;
		vertical-align: middle;
		padding: 3px 0px 3px 3px;
		border-right: solid 1px white;
	}
	tr:last-child td {
		border-top: solid 1px white;
		background: powderblue !important;
		padding: 5px;
		font-weight: bold;
		text-align: center !important;	
	}
	caption > div {
		float: right;
		color: navy;
	}
	caption img {
		height: 16px;
		float:none;
		vertical-align: bottom;
	}
	h3 {
		text-align: center;
		color: navy;
	}
	div#head > img {
		vertical-align: bottom;
		margin-right: 5px;
		height: 24px;
	}
	h5 {
		text-align: center;
		margin: 0px;
	}

	#content{
		width:960px;
		margin: auto;
		background: #B0C4DE;
		padding-bottom: 5px;}
	#container{
		width:960px;
		margin: auto;
	}
	.header-history{
		width:960px;
		height: 40px;
		background: #2F4F4F;
		margin-top: 10px;
	}
	.header-history span{
		font-size: 20px;
		font-weight: bold;
		color: white;
		margin-left: 10px;
		line-height: 40px;
	}
	#bottom{
		width:960px;
		background: #A9A9A9;
		padding: 3px;
		margin:auto;
	}
	td img {
		height: 16px;
		vertical-align: top;
	}
	button.disable{
		cursor: default;
		background: whitesmoke !important;
		color: silver !important;
	}
	button.disable:hover {
		background: whitesmoke !important;
	}
</style>
<script>
$(function() {
	$('button#index').click(function() {
		location.href = "main.php";
	});
	$('button').click(function() {
		ajaxSend($(this), 'update');
	});

	$('button.bt-rate').click(function() {
		ajaxSend1($(this), 'updaterating');
	});

	
});


function ajaxSend(a, action) {
	var proid = a.attr('data-id');
	var orderID = a.attr('data-order'); 
	var d = {'action':action, 'pro_id':proid, 'order_id':orderID};
	$.ajax({
		url: 'order-action.php',
		data: d,
		dataType: 'html',
		type: 'post',
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		success: function(result) {
			location.reload();
		},
		complete: function() {
			$.unblockUI();
		}
	})	;
}

function ajaxSend1(a, action) {
	var proid = a.attr('data-id');
	var orderID = a.attr('data-order'); 
	var d = {'action':action, 'pro_id':proid, 'order_id':orderID};
	$.ajax({
		url: 'rating-action.php',
		data: d,
		dataType: 'html',
		type: 'post',
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		success: function(result) {
			location.reload();
		},
		complete: function() {
			$.unblockUI();
		}
	})	;
}

</script>
<div id="content">
<div class="header-history">
	<span>ประวัติการสั่งซื้อ</span>
</div>
<?php
include "dblink.php";
$err = "";
$name = "";
$email = $_SESSION['email'];
$pswd = $_SESSION['password'];
if($_POST['email']) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];
	//ตรวจสอบว่าอีเมลและรหัวผ่านที่ใส่เข้ามาถูกต้องหรือไม่
	$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pswd'";
	$r = mysqli_query($link, $sql);
	if(mysqli_num_rows($r)==0) {
		$err = '<h2 class="warning">ท่านใส่อีเมลหรือรหัสผ่านไม่ถูกต้อง</h2>';
	}
	else{
	$cust_id = $data['cust_id'];
		$sql = "SELECT *, DATE_FORMAT(order_date, '%d-%m-%Y') AS order_date
					FROM orders WHERE cust_id = '$cust_id' ORDER BY order_id DESC LIMIT 50"; 
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) == 0) {
			echo "<h3>ไม่พบ</h3>";
		}
		echo "<h3>ประวัติการสั่งซื้อของคุณ: $name</h3>";
		while($data = mysqli_fetch_array($r)) {
			$order_id = $data['order_id'];
			$date =  $data['order_date'];
			//กำหนดภาพให้สอดคล้องกับสถานะการโอนเงินและจัดส่ง
			$img_pay = "images/no.png";
			$img_delivery = "images/no.png";
			if($data['paid'] == "yes") {
				$img_pay = "images/yes.png";
			}
			$sql = "SELECT order_details.*, products.pro_id, products.pro_name, products.price  
			 			FROM order_details LEFT JOIN products 
						ON order_details.pro_id = products.pro_id
						WHERE order_details.order_id = '$order_id'";
			$result = mysqli_query($link, $sql);	
?>
  				<table border="0">
  					<caption>
   	 					วันที่: <?php echo $date; ?> &nbsp;&nbsp;
                        รหัสการสั่งซื้อ: <?php echo $order_id; ?>
  						<div><img src="<?php echo $img_pay; ?>"> การชำระเงิน  - 
                         		<img src="<?php echo $img_delivery; ?>"> การจัดส่งสินค้า</div>
  					</caption>
				<tr><th>ชื่อสินค้า</th><th>คุณลักษณะ</th><th>จำนวน</th><th>ราคา</th><th>รวม</th><th>เรทติ้ง/th></tr>
				<?php
					$grand_total = 0;
					while($order = mysqli_fetch_array($result)) {
						$sub_total = $order['quantity'] * $order['price'];
				?>
				<tr>
    				<td><?php echo $order['pro_name']; ?></td>
    				<td><?php echo $order['quantity']; ?></td>
    				<td><?php echo $order['price']; ?></td>
   					<td><?php echo number_format($sub_total); ?></td>
				</tr>
				<?php
					$grand_total += $sub_total;
				}
				?>
				<tr><td colspan="4">รวมทั้งหมด</td><td><?php echo number_format($grand_total); ?></td></tr>
			</table>
<?php
		}  //end while
	}
}
if(isset($_SESSION['user'])){
		$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pswd'";
		$r = mysqli_query($link, $sql);
		$data = mysqli_fetch_array($r);
		$name = $data['name'] ;
		
		$cust_id = $data['cust_id'];
		$sql = "SELECT *, DATE_FORMAT(order_date, '%d-%m-%Y') AS order_date
					FROM orders WHERE cust_id = '$cust_id' ORDER BY order_id DESC LIMIT 50"; 
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) == 0) {
			echo "<h3>ไม่พบ</h3>";
		}
		echo "<h3>ประวัติการสั่งซื้อของคุณ: $name</h3>";
		while($data = mysqli_fetch_array($r)) {
			$order_id = $data['order_id'];
			$date =  $data['order_date'];
			//กำหนดภาพให้สอดคล้องกับสถานะการโอนเงินและจัดส่ง
			$img_pay = "images/no.png";
			if($data['paid'] == "yes") {
				$img_pay = "images/yes.png";
			}
			$sql = "SELECT order_details.*, products.pro_id, products.pro_name, products.price  
			 			FROM order_details LEFT JOIN products 
						ON order_details.pro_id = products.pro_id
						WHERE order_details.order_id = '$order_id'";
			$result = mysqli_query($link, $sql);	
?>
  				<table border="0">
  					<caption>
   	 					วันที่: <?php echo $date; ?> &nbsp;&nbsp;
                        รหัสการสั่งซื้อ: <?php echo $order_id; ?>
  						<div><img src="<?php echo $img_pay; ?>"> การชำระเงิน  </div>
  					</caption>
				<tr><th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคา</th><th>รวม</th>
				
				<th>สถานะการจัดส่งสินค้า</th><th>แจ้งรับสินค้า</th><th>เรทติ้ง</th>
				
				</tr>
				<?php
					$grand_total = 0;
					while($order = mysqli_fetch_array($result)) {
						$sub_total = $order['quantity'] * $order['price'];
						$id = $order['pro_id'];
						$img_delivery = "images/no.png";
						$img_recieve = "images/no.png";
						$class = 'enable';
						if($order['delivery'] == 'yes'){
							$img_delivery = "images/yes.png";
						}
						if($order['recieve'] == 'yes'){
							$class = 'disable';
							$img_recieve = "images/yes.png";
							
						}
				?>
				<tr>
    				<td><?php echo $order['pro_name']; ?></td>
    				<td><?php echo $order['quantity']; ?></td>
    				<td><?php echo $order['price']; ?></td>
   					<td><?php echo number_format($sub_total); ?></td>
   					<td><img src="<?php echo $img_delivery; ?>"></td>
   					<td>
   					<img src="<?php echo $img_recieve; ?>">
   					<?php
   					if($data['paid'] == "yes" && $order['delivery'] == "yes"){
   						?>
   						<button class="<?php echo $class; ?> btn btn-primary" data-id="<?php echo $id; ?>" data-order="<?php echo $order['order_id']; ?>">ได้รับแล้ว</button></td>

   						
   					<?php
   				    }
   					?>
   					<td>
   						<?php
   						if($order['recieve'] == "yes"){
   						?>
   						<span class="star-rate">
        			
        			<input type="radio" name="star_<?php echo $id; ?>" value="1"  checked>1
        			<input type="radio" name="star_<?php echo $id; ?>" value="2">2
        			<input type="radio" name="star_<?php echo $id; ?>" value="3">3
        			<input type="radio" name="star_<?php echo $id; ?>" value="4">4
        			<input type="radio" name="star_<?php echo $id; ?>" value="5">5
        			<button class="bt-rate" type="button" data-id="<?php echo $id; ?>" data-order="<?php echo $order['order_id']; ?>"<?php if($order['rating'] == "yes") {echo "disabled";}?>>Rate</button>
      </span>
   						<?php
   						}
   						?>
   					</td>
   					
				</tr>
				<?php
					$grand_total += $sub_total;
				}
				?>

				<tr><td colspan="4">รวมทั้งหมด</td><td><?php echo number_format($grand_total); ?></td><td></td><td></td></tr>
			</table>
<?php
		}  //end while
	}		//end else


//ถ้าไม่มีข้อมูลโพสเข้ามา หรือเกิดข้อผิดพลาด ให้แสดงฟอร์มสำหรับใส่อีเมลและรหัสผ่าน
if(!isset($email) && !isset($pswd)) {   
?>
<form method="post"><?php echo $err; ?>
	<span>กรุณาใส่อีเมลและรหัสผ่านที่ท่านใช้ในการสั่งซื้อสินค้า</span><br>
	<input type="email" name="email" placeholder="อีเมล *" required value="<?php echo $email;?>">
    <input type="password" name="pswd" placeholder="รหัสผ่าน *" maxlength="20" required>
    <button type="submit">ตกลง</button>
    
</form>
<?php
}
?>
</div>
<div id="bottom">
<button id="index">&laquo; หน้าแรก</button>
</div>
</div>

</div>
</div>
</body>
</html>
<?php  mysqli_close($link); ?>