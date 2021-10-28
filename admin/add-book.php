<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {


































    
header('location:index.php');
}
else {



































    
if (isset($_POST['add'])) 
{
        //var_dump('katebde');
        $bookname = $_POST['bookname'];
        $no_of_copies = $_POST['no_of_copies'];
        $category = $_POST['category'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        //$pdf = $_POST['pdf'];
        $pdf = $_FILES['pdf'];
        if ($_FILES['pdf']['type'] == "application/pdf") {
            $source_file = $_FILES['pdf']['tmp_name'];
            $pdf = $newName = time() . str_replace(" ", "_", $_FILES['pdf']['name']);
            $dest_file = "uploads/" . $newName;


            if (file_exists($dest_file)) {
                print "The file name already exists!!";
            }
            else {
                move_uploaded_file($source_file, $dest_file)
                    or die("Error!!");
                // if ($_FILES['pdf']['error'] == 0) {
                //     print "Pdf file uploaded successfully!";
                //     print "<b><u>Details : </u></b><br/>";
                //     print "File Name : " . $_FILES['pdf']['name'] . "<br.>" . "<br/>";
                //     print "File Size : " . $_FILES['pdf']['size'] . " bytes" . "<br/>";
                //     print "File location : upload/" . $_FILES['pdfFile']['name'] . "<br/>";

                // }
                //changed to here
                $sql = "INSERT INTO  tblbooks(BookName,no_of_copies,CatId,AuthorId,ISBNNumber,BookPrice,Status,pdf)
            VALUES(:bookname,:no_of_copies,:category,:author,:isbn,:price,:status,:pdf)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
                $query->bindParam(':no_of_copies', $no_of_copies, PDO::PARAM_STR);
                $query->bindParam(':category', $category, PDO::PARAM_STR);
                $query->bindParam(':author', $author, PDO::PARAM_STR);
                $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
                $query->bindParam(':price', $price, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->bindParam(':pdf', $pdf, PDO::PARAM_STR);
                $query->execute();
                $sql = "INSERT INTO  available(BookName,CatId,AuthorId,BookPrice,Status) VALUES(:bookname,:no_of_copies,:category,:author,:price,:status)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
                $query->bindParam(':category', $category, PDO::PARAM_STR);
                $query->bindParam(':author', $author, PDO::PARAM_STR);
                $query->bindParam(':price', $price, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->bindParam(':pdf', $pdf, PDO::PARAM_STR);
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();
            //changed to here
            }
        }
        //pdf file
        //$pdf = $_FILES['pdf']['name'];
        //var_dump('done');
        // $sql = "INSERT INTO  tblbooks(BookName,no_of_copies,CatId,AuthorId,ISBNNumber,BookPrice,Status,pdf)
        //  VALUES(:bookname,:no_of_copies,:category,:author,:isbn,:price,:status,:pdf)";
        // $query = $dbh->prepare($sql);
        // $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        // $query->bindParam(':no_of_copies', $no_of_copies, PDO::PARAM_STR);
        // $query->bindParam(':category', $category, PDO::PARAM_STR);
        // $query->bindParam(':author', $author, PDO::PARAM_STR);
        // $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        // $query->bindParam(':price', $price, PDO::PARAM_STR);
        // $query->bindParam(':status', $status, PDO::PARAM_STR);
        // $query->bindParam(':pdf', $pdf, PDO::PARAM_STR);
        // $query->execute();
        // $sql = "INSERT INTO  available(BookName,CatId,AuthorId,BookPrice,Status) VALUES(:bookname,:no_of_copies,:category,:author,:price,:status)";
        // $query = $dbh->prepare($sql);
        // $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        // $query->bindParam(':category', $category, PDO::PARAM_STR);
        // $query->bindParam(':author', $author, PDO::PARAM_STR);
        // $query->bindParam(':price', $price, PDO::PARAM_STR);
        // $query->bindParam(':status', $status, PDO::PARAM_STR);
        // $query->bindParam(':pdf', $pdf, PDO::PARAM_STR);
        // $query->execute();
        // $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) 
{
            $_SESSION['msg'] = "Book Listed successfully";
            header('location:manage-books.php');
        }
        else 
{
            $_SESSION['error'] = "Something went wrong. Please try again";
            header('location:manage-books.php');
        }
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Add Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> -->

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php'); ?>
<!-- MENU SECTION END-->
    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post" enctype="multipart/form-data">
<div class="form-group">
<label>Book Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" autocomplete="off"  required />
</div>
<label>No of copies<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="no_of_copies" autocomplete="off"  required />
</div>


<div class="form-group">
<label> Category<span style="color:red;">*</span></label>
<select class="form-control" name="category" required="required">
<option value=""> Select Category</option>
<?php



























    
$status = 1;
    $sql = "SELECT * from  tblcategory where Status=:status";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) 
{
        foreach ($results as $result) 
{ ?>  
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->CategoryName); ?></option>
 <?php
        }
    }?> 
</select>
</div>


<div class="form-group">
<label> Author<span style="color:red;">*</span></label>
<select class="form-control" name="author" required="required">
<option value=""> Select Author</option>
<?php


























    
$sql = "SELECT * from  tblauthors ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) 
{
        foreach ($results as $result) 
{ ?>  
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->AuthorName); ?></option>
 <?php
        }
    }?> 
</select>
</div>

<div class="form-group">
<label>ISBN Number<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="isbn"  required="required" autocomplete="off"  />
<p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
</div>

 <div class="form-group">
 <label>Price<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="price" autocomplete="off"   required="required" />
 </div>
 <div class="form-group">
<label>Status</label>
 <div class="radio">
<label>
<input type="radio" name="status" id="status" value="1" checked="checked">Active
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="status" id="status" value="0">Inactive
</label>
</div>
<div class="form-group">
<input type="file" id="input-file-now-custom-2" name="pdf" class="dropify" data-height="500" /> 
 </div>

</div>
<button type="submit" name="add" class="btn btn-info">Add </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php'); ?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php
}?>
