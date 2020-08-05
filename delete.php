<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}
if(isset($_POST['delete']) && isset($_POST['autos_id'])){
	$sql="DELETE FROM autos WHERE autos_id= :zip";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array(
		':zip'=>$_POST['autos_id']));
	$_SESSION['success']="Record Deleted";
	header("Location: index.php");
	return;
}
if(!isset($_GET['autos_id'])){
	$_SESSION['error']="Missing user_id";
	header("Location: index.php");
	return;
}
$stmt = $pdo->prepare("SELECT make FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<head>
    <title>Welcome to Autos Database</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<p>Confirm: Deleting <?php echo htmlentities($row['make']);?></p>
<form method="POST">
<input type="hidden" name="autos_id" value="<?php echo $_GET['autos_id']; ?>">
<input type="submit" name="delete" value="Delete"><a href="index.php">Cancel</a>
</form> 
</div>
</body>
</html>