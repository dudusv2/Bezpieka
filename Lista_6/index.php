<?php 
	include_once 'header.php';
?>
<section class="main-container">
	<div class="main-wrapper">
		
		<h2>Welcom in our bank </h2>
		<?php
			if(isset($_SESSION['u_id'])){
				echo "You are login ".$_SESSION['u_uid']."<br>
				<div id='account_no'>account number: ".$_SESSION['u_account']."</div>";
				
				}
			?>
	</div>
</section>
	
<?php
	include_once 'footer.php';
?>
