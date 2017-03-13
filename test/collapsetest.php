<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
<style>
	/* Style the buttons that are used to open and close the accordion panel */
button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
    text-align: center;
    margin-left: 50%;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
button.accordion{
	width: 40%;
}
button.accordion.active, button.accordion:hover {
    background-color: #ddd;
    width: 50%;
}

/* Style the accordion panel. Note: hidden by default */
div.panel {
    padding: 0 18px;
    background-color: red;
    display: none;
}
div.ShowPanel{
	padding: 0 18px;
    background-color: red;
    display: block;
}
@media only screen and (max-width: 768px) {
	button.accordion{
	width: 100%;
}
button.accordion.active, button.accordion:hover {
    background-color: #ddd;
    width: 100%;
}
}
</style>



<script>

$(document).ready(function() {
        $('.accordion').click(function() {
            $(this).addClass('active');
            $(this).next().toggleClass("ShowPanel");
        });
    });
    
</script>
<!-- this page shows the user all of their current loans by connection to the db.  The delete button doesnt work YET--> 
<style>
	.PastBooking{
		background-color: red;
	}
	.TodayBooking{
		background-color: yellow;
	}
</style>

<?php
echo "<p>Your Bookings</p>"; // dont delete this the <p> is what stops everything hiding under the menu bar!

//need to use the users information and the database connection files
require '../php/user_info.php';
require '../php/Conection.php';

//this is the sql to get all the needed info from the joined tables to show the user their bookings

// hey guys i just changed the SQL so it orders it by the most recent booking first this was done byt using ORDER BY DESC which you can see below
	$sql = "SELECT Asset.AssetDescription, Loan.LoanUID, Loan.LoanDate, Loan.LoanConfirm, LoanContent.ReturnDate, User.UserFName, Owner.OwnerLocation, User.UserCampus 
	FROM Loan 
	JOIN LoanContent on Loan.LoanUID = LoanContent.LoanUID 
	JOIN Asset on LoanContent.AssetUID = Asset.AssetUID 
	JOIN Owner on Asset.OwnerUID = Owner.OwnerUID 
	JOIN User on Owner.OwnerUID = User.UserUID  
	WHERE Loan.UserUID = '$user' ORDER BY Loan.LoanUID DESC ";
	 
	//just a variable to store the query result
	$result = mysqli_query($conn, $sql);

		//if there is a result from the query (the user does have loans) put headers into a table
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
			//use the results as variables
		while($row = mysqli_fetch_assoc($result)) 
		{
			$LoanID = $row["LoanUID"];
			$Asset =$row["AssetDescription"];
			$LoanDate =$row["LoanDate"];
			$Confirmed = $row["LoanConfirm"];
			$ReturnDate = $row["ReturnDate"];
			$UserFName = $row['UserFName'];
			$OwnerLocation =$row["OwnerLocation"];
			$UserCampus =$row["UserCampus"];
			
			if ($Confirmed == 0){
					$Confirmed ="Pending";
					
			}
			elseif ($Confirmed == 1){
					$Confirmed = "Confirmed";
				}
			elseif ($Confirmed == 2){
					$Confirmed = "Refused";
			}

			$Create = date_create($ReturnDate);
			$Create = $Create->format("Y/m/d");
			$TodaysDay = date("Y/m/d");
			echo "
			<button class='accordion'>$Asset</button>
				<div class='panel'>
  					<p>$LoanDate - $Create </p>
  					<div>$UserFName $OwnerLocation $UserCampus $Confirmed</div>
  					<div><button class='deleteItem $Asset' value='$Asset' id='Infobutton1'>Delete</button></div>
				</div>"	;

			

		}
	} else //if the user does not have any loans
	{
		echo "<table>
			<tr class='toptitles'>
				<th>Item</th>
				<th>Pickup Date</th>
				<th>Return Date</th>
				<th>Owners Name</th>
				<th>Item Location</th>
				<th>Campus</th>
							
			</tr>";
	}
	mysqli_close($conn);
	?>
	<!---insert into Loan (UserUID, LoanDate)values ('mh709', '2017-02-21');
	insert into LoanContent (LoanUID, AssetUID,SetReturn,ReturnDate)values (1,409,1,'2017-03-21');-->