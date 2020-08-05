<?php
require_once "pdo.php";
session_start();
if(isset($_POST['cancel'])){
	header("Location: index.php");
	return;
}
if(isset($_POST['make'])&&isset($_POST['model'])&&isset($_POST['year'])&&isset($_POST['mileage'])){
	if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }
	elseif(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
}
$sql="UPDATE autos SET make=:make, model=:model, year=:year, mileage=:mileage where autos_id=:autos_id";
$stmt=$pdo->prepare($sql);
$stmt->execute(array(
	':make'=>$_POST['make'],
	':model'=>$_POST['model'],
	':year'=>$_POST['year'],
	':mileage'=>$_POST['mileage'],
	':autos_id' => $_POST['autos_id']));
	$_SESSION['success']="Record updated";
	header("Location: index.php");
	return;
}
if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}
$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<head>
<title>Aayush Jain</title>
<?php require_once "bootstrap.php";?>
</head>
<body>
<div class="container">
<h1>Editing Automobile</h1>
<?php
if(isset($_SESSION['error'])){
	echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}
?>
<form method="post">
        <p>Make<input type="text" name="make" size="40" value="<?php echo $row['make']; ?>"></p>
        <p>Model<input type="text" name="model" size="40" value="<?php echo $row['model']; ?>"></p>
        <p>Year<input type="text" name="year" size="10" value="<?php echo $row['year']; ?>"></p>
        <p>Mileage<input type="text" name="mileage" size="10" value="<?php echo $row['mileage']; ?>"></p>
        <input type="hidden" name="autos_id" value="<?php echo $_GET['autos_id']; ?>">
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>
