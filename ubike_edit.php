<?php
	include("../function/condb.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>index.php</title>
  <style>
	body {
		margin: 0px;
	}
	a {
		text-decoration: none;
		font-family: 微軟正黑體,新細明體,標楷體;
		font-weight: bold;
		font-size: 17px;
	}
	
	.menu {
		position:fixed;
		width: 100%;
		height: 40px;
		background-color: blue;
		z-index: 9999999;
	}
	
	.menu a {
		text-decoration: none;
		color: white;
		font-family: 微軟正黑體,新細明體,標楷體;
		font-weight: bold;
		font-size: 17px;
	}
	
	.menu_css {
		float: left;
		width: 70%;
		height: inherit;
		overflow: hidden;
		font-family: 微軟正黑體,新細明體,標楷體;
		font-weight: bold;
		font-size: 17px;
		color: white;
		border-spacing: 0px;
	}
	.menu_css tr {
		display: block;
	}
	.menu_css td {
		height: 40px;
		padding: 0px 15px 0px 15px;
		white-space: nowrap;
	}
	.menu_css td:hover {
		background-color: black;
	}
	
	.menu_search{
		width: 30%;
		height: inherit;
		white-space: nowrap;
		overflow: hidden;
		font-family: 微軟正黑體,新細明體,標楷體;
		font-weight: bold;
		font-size: 17px;
		color: white;
	}
	.menu_search tr {
		display: block;
	}
	.menu_search td {
		height: 40px;
		padding: 0px 15px 0px 15px;
	}
	.menu_search td:hover {
		background-color: black;
	}
	
	.content {
		position: relative;
		word-wrap: break-word;
		width: 100%;
		top: 40px;
		background-color: #f1f1f1;
	}
	
	.inner_content {
		padding: 50px 130px 220px 130px;
	}
	
	.inner_content table {
		background-color: white;
	}
	
	li img {
		width: 100%;
		height: 100%;
	}
	
	input[type=text] {
		color: black;
	}
	
	form {
		margin-bottom: 0em;
	}
  </style>
  <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
  <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.css">
  <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.min.css">
  <script>
	function ChangeContent(account_number1){
		document.getElementById("account_number").value = account_number1;
		document.getElementById("mfrom").action = "ubike_edit.php";
		document.getElementById("mfrom").submit();
	}
	
	function UpdateContent(){
		document.getElementById("location").value = document.getElementById("location").value;
		document.getElementById("type").value = document.getElementById("type").value;
		document.getElementById("rental_time").value = document.getElementById("rental_time").value;
		document.getElementById("account_number").value = document.getElementById("account_number").value;
		document.getElementById("mfrom").action = "ubike_mdysave.php";
		document.getElementById("mfrom").submit();
	}
	
	function DeleteContent(){
		document.getElementById("account_number").value = document.getElementById("account_number").value;
		document.getElementById("mfrom").action = "ubike_delsave.php";
		document.getElementById("mfrom").submit();
	}
	
	function InsertContent(){
		document.getElementById("mfrom").action = "ubike_add.php";
		document.getElementById("mfrom").submit();
	}
  </script>
</head>
<body>
<form id="mfrom" method="post" action="ubike_edit.php">
	<input type="hidden" id="account_number" name="account_number" value="<?php echo isset($_POST["account_number"])?$_POST["account_number"]:""?>">
	<div class="menu">
		<table class="menu_css">
			<tr>
				<td>
					<a href="../index.php">主頁</a>
				</td>
				<td>
					<a href="ubike.php">查詢記錄</a>
				</td>
				<td>
					<a href="ubike_edit.php">編輯記錄</a>
				</td>
			</tr>
		</table>
		<table class="menu_search">
			<tr>
				<td>
					<form method="post" action="ubike.php">
					Search
					  <input type="text" id="keyword" name="keyword" value="" placeholder="輸入搜尋關鍵字" />
					  <input type="submit" value="送出">				
					</form>
				</td>
			</tr>
		</table>
	</div>
	<div class="content">
		<div class="inner_content">
			<table class="table">
			  <input class="btn btn-default" type="button" value="新增" onclick="InsertContent();">
			  <div style="text-align: left;font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size: 15px;font-weight: bold;">
				共有 
				<?php
					$sql = "SELECT * FROM borrower_record";
					if($result = mysqli_query($conn,$sql)){
						$rowcount= mysqli_num_rows($result);
						echo $rowcount;
					}
				?>
				 筆租借資料
			  </div>
			  <thead>
				<tr> 
				  <th>紀錄編號</th> 
				  <th>租借地點</th> 
				  <th>自行車種類</th> 
				  <th>租借時間</th> 
				  <th>帳戶編號</th 
				</tr>  
			  </thead> 
			  <tbody> 
				<?php
					if(isset($_POST["account_number"]) && !empty($_POST["account_number"])){
						$account_number = $_POST["account_number"];
						
						$sql = "SELECT t.location,t.type,t.rental_time,t.account_number FROM `borrower_record` AS t WHERE t.account_number = ?";
						if($stmt = $conn->prepare($sql)){
						$stmt->bind_param("s", $account_number);
						$stmt->execute();
						$stmt->bind_result($location,$type,$rental_time,$account_number);				
						if($stmt->fetch()){						
				?>
						<tr> 
						  <th scope="row">
						  	<a class="btn btn-default" role="button" onclick="UpdateContent();">按我更新</a>
						  	<a class="btn btn-default" role="button" onclick="DeleteContent();">按我刪除</a>
						  </th> 
						  <td><input type="text" id="location" name="location" value="<?php echo $location;?>"/></td> 
						  <td><input type="text" id="type" name="type" value="<?php echo $type;?>"/></td> 
						  <td><input type="text" id="rental_time" name="rental_time" value="<?php echo $rental_time;?>"/></td> 
						  <td id="account_number"><?php echo $account_number;?></td>
						</tr> 
				<?php
						}
						}
					}else if (isset($_POST["keyword"]) && !empty($_POST["keyword"])){
						$keyword = $_POST["keyword"];
						
						if($keyword == ''){
						  $keyword = '%';
						}else{
						  $keyword = '%'.$keyword.'%';
						}
						
						$sql = "SELECT t.location,t.type,t.rental_time,t.account_number FROM `borrower_record` t where t.location like ? or t.type like ? or t.rental_time like ? or t.account_number like ?";
						if($stmt = $conn->prepare($sql)){
						$stmt->bind_param("sssi", $keyword, $keyword, $keyword, $keyword);
						$stmt->execute();
						$stmt->bind_result($location,$type,$rental_time,$account_number);
						$count = 0;
						while($stmt->fetch()){
						$count++;
				?>
							<tr> 
							  <th scope="row"><?php echo $count;?></th> 
							  <td><?php echo $location;?>
							  </td> 
							  <td><?php echo $type;?></td> 
							  <td><?php echo $rental_time;?></td> 
							  <td><a onclick="ChangeContent('<?php echo $account_number;?>');"><?php echo $account_number;?></td></a>
							</tr> 
				<?php
						}			
						}
					}else{
						$sql = "SELECT t.location,t.type,t.rental_time,t.account_number FROM `borrower_record` t";
						if($stmt = $conn->prepare($sql)){
						$stmt->execute();
						$result = $stmt->get_result();
						$count = 0;
						
						while($rows = $result->fetch_assoc()){
						$count++;
				?>
						<tr> 
						  <th scope="row"><?php echo $count;?></th> 
						  <td><?php echo $rows['location'];?>
						  </td> 
						  <td><?php echo $rows['type'];?></td> 
						  <td><?php echo $rows['rental_time'];?></td> 
						  <td><a onclick="ChangeContent('<?php echo $rows['account_number'];?>');"><?php echo $rows['account_number'];?></td></a>
						</tr> 
				<?php
						}
						}
					}
				?>
			  </tbody> 
			</table>
		</div>
	</div>
</form>
</body>
</html>