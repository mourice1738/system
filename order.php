<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==1)
    {   
header('location:index1.php');
}
else{ 
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tblbooks  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Category deleted scuccessfully ";
header('location:manage-books.php');

}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BREM | Manage Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="assets/css/style1.css">

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/headers.php');?>
<!-- MENU SECTION END-->
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT StudentId,FullName,Address,EmailId,MobileNumber from  tblstudents  where StudentId=:sid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  



<?php } ?>


<div class="form_container">
        <div class="mini_container">
        <div class="forms">
            <form class="form_one">
                <label>name</label><br>
            <div class="names">
                <input type="text" value="<?php echo htmlentities($result->FullName);?>" >
            </div>
            <label>Address</label><br>
            <div class="names"  >
                <input type="text"value="<?php echo htmlentities($result->Address);?>" >
            </div>
            <label>Email</label><br>
            <div class="names">
                <input type="text"value="<?php echo htmlentities($result->EmailId);?>" >
            </div>
            <label>Contact</label><br>
            <div class="names">
                <input type="text" value="<?php echo htmlentities($result->MobileNumber);?>">
            </div>
        </form>



        <form class="form_two">
            
            <label>Bookname <span>copies</span></label><br>
            <div class="name">
                <input type="text" value="<?php echo htmlentities($result->BookName);?>" >
                <input type="text"value="<?php echo htmlentities($result->No_of_copies);?>">
            </div>
            <label>category</label><br>
            <div class="names"  >
                <input type="text" value="<?php echo htmlentities($result->CategoryName);?>">
            </div>
            <label>Author</label><br>
            <div class="names">
                <input type="text"value="<?php echo htmlentities($result->AuthorName);?>" >
            </div>
            <label>Price</label><br>
            <div class="names">
                <input type="text" value="<?php echo htmlentities($result->BookPrice);?>">
            </div>
        </form>
        <?php } ?>
        </div>
        <div class="place_order">
            <button type="submit" name="order">Place order</button>
        </div>
        </div>
        

    </div>

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
