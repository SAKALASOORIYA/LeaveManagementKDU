<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
$msg = "done";
if (isset($_POST['delete'])) {
    $sql="update tblleaves set Status=4 where assign_staff_id='$session_id'";
	$query = $dbh->prepare($sql);
	$query->execute();
}
if(isset($_POST['accept']))
    {
    $sql="update tblleaves set Status=0 where assign_staff_id='$session_id'";
	$query = $dbh->prepare($sql);
	$query->execute();
    }

?>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/kdu2.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<?php include('includes/navbar.php')?>

	

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL MY LEAVE</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">ASSIGNER NAME</th>
								<th>DATE FROM</th>
								<th>DATE TO</th>
								<th>NO. OF DAYS</th>
                                <th>STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								
								 <?php 
                                    $sql = "SELECT *,l.Status as stats from tblleaves l,tblemployees e where e.emp_id=l.empid and  assign_staff_id = '$session_id'";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    {               ?>  

								  <td><?php echo htmlentities($result->FirstName." ".$result->LastName);?></td>
                                  <td><?php echo htmlentities($result->FromDate);?></td>
                                  <td><?php echo htmlentities($result->ToDate);?></td>
                                  <td><?php echo htmlentities($result->num_days);?></td>
                                  <td><?php $stats=$result->stats;
                                        
                                       if($stats==0){
                                        ?>
                                           <span style="color: green">Approved</span>
                                            <?php } if($stats==4)  { ?>
                                           <span style="color: red">Not Approved</span>
                                            <?php } if($stats==3)  { ?>
	                                       <span style="color: blue">Pending</span>
	                                       <?php } ?>

                                    </td>
                                    <td>
                                    <form  method="post">
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <button class="dropdown-item" name="accept" type="submit"><i class="dw dw-eye"></i> Accept</button>
                                                <button class="dropdown-item" name="delete" type="submit"><i class="dw dw-delete-3"></i> Delete</button>
                                            </div>
                                        </div>
                                    </form>
								    </td>
							</tr>
							<?php $cnt++;} }?>  
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>