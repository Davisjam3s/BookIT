<style>
.phpechofront2
{
    display:none
}
    input, select{
      width: 100%;
      border: none;
    }
    input:disabled, select:disabled{
      border: none;
      background-color: transparent;
    }
    input:disabled, select:disabled{
      color: black;
    }
    .editItem {
      width: 100%;
      height: 100%;
    }
    .hidden1, .hidden2
    {
      display: none;
    }
</style> <!--this is to make the from disapear when we dont need it-->
<!--
    ** This is the page for the admin to manage the users on the website, here the admin should be able to Ban users, Remove Users and make other Users Admins/Owners

    **This page starts with the style tag, this was to fix a bug where the from was showing on the page when it should not have

    ** JQuery is used  this is for the button press when the button named owner is pressed it will disaplay the form to that the user can fill it out and completr it, this is so that the user can add a new owner to the owner table

    ** PHP is used to echo the page contents of the page, it is used to echo a table where the user can see the users that have created an account, it echos buttons so thaty the user is able to intereact with indivudal users THe PHP uses SQL in order to echo out the users within the User table using SELECT * 

    ** it uses a small if statement in order to modify the values from the database into an readable format so the user can read it, as numbers dont mean anything to people 

    ** Blow this is the hidden form , this is where the user will eneter the information about the new owner, this from is only activated when the make owner button is pressed, its value is also dictated buy the value of the button this meaning that it SHOULD add a new owner based on the button pressed

    ** it has more Jqueery to get the value from the the button and put it in the text box, that is disabled so the admin can 


    **The page was created by James Davis, Matt Hood
    **Commented by James Davis
    **Tasks for this page 
        * The Admin cannot ban Users
        * The admin cannot edit a users information
        * the user cant modify any users info
        * make a button for the user to remove an owner, you will need to delete their assest first 
        *the make owner button still shows when the user already is an owner 


-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
$(document).ready(function() // wait till the page is ready
{
    $(".editItem").click(function() // wait till this button has been pressed
      { 
          $(".phpechofront2").show(); // show the edit nav panel
      });
  });
</script>




<?php
echo "<p>Edit Owner Details</p>"; // description of control
echo "<h2 class='response'></h2>"; // what it does and warning if you do somnething wrong
require '../../../php/Conection.php';// connection to database

$sql = "SELECT * FROM Owner order by OwnerUID";//query database for Owners Details
$result = mysqli_query($conn, $sql);//run query
echo "<table>
		<tr class='toptitles'>
			<th>Owner</th>
			<th>Room</th>
			<th>Email</th>
			<th>Group</th>
			<th class='AdminControl'>Edit Owner</th>
      <th class='hidden2'>Hidden Value</th>
      <th class='hidden1'>Submit</th>
      <th class='hidden1'>Cancel</th>
		</tr>";//headings for Owner Table

//check for results		
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
    {
      $OwnerUID =$row["OwnerUID"];
      $OwnerLocation =$row["OwnerLocation"];
      $GroupUID =$row["GroupUID"];
      $OwnerEmail =$row["OwnerEmail"];

	// change database variable to readable form
   	if ($GroupUID == '1') {
    		$GroupUID = 'School of Computing';
        $FillForm = "<select class='GroupUID$OwnerUID' disabled='true'>
            
            <option value='1'selected>School of Computing</option>
            <option value='2'>Digital Humanities</option>
          </select>";
    	}
    	elseif ($GroupUID = '2') {
    		$GroupUID = 'Digital Humanities';
        $FillForm = "<select class='GroupUID$OwnerUID' disabled='true'>
            
            <option value='1'>School of Computing</option>
            <option value='2' selected >Digital Humanities</option>
          </select>";
    	}
		
		// set up the inputs and selection boxes that can be enabled when needed to edit
       echo "<tr class='$OwnerUID'>
				<td>$OwnerUID</td>
				<td><input class='OwnerLocation$OwnerUID' disabled='true'  value='$OwnerLocation'></td>
				<td>$OwnerEmail</td>
				<td>
					
          $FillForm
				</td>
				<td class='AdminControl'><button value='$OwnerUID' class='editItem $OwnerUID' >Edit Owner</button></td>
        <td class='hidden2'><input type='text' id='Owner' required class='FormItems testname' disabled='true'></td>
        <td class='hidden1'><button class='Infobutton2'> Submit </button></td>
        <td class='hidden1'><button class='CancelDelete'> Cancel </button>   </td>
			</tr>";
    }
} else
{
    echo "<h2>No Users On Database yet</h2>";
}

mysqli_close($conn);
?>




<script>
$(document).ready(function() {
        $('.editItem').click(function() {
            $(".testname").val($(this).val());
            $(".hidden1").show();
            $(".AdminControl").hide();

        });
    });  
</script>


<script>
// some complicated script. actuyally written by James, i made it myself lolololol, no joke it worked, it worked so well i named the var after me 
$(document).ready(function() // wait till the page is ready
{
    $(".editItem").click(function() // wait till this button has been pressed
      { 
            var  jam =  $(this).val(); // value of the button 
           
          $( "input[class*="+jam+"]" ).prop('disabled',false).height(40); // enable any class with varible
          $( "select[class*="+jam+"]" ).prop('disabled',false).height(40); // enable any input type select with varible 
          $( "input[class|='OwnerLocation"+jam+"']" ).attr("id","OwnerLocation");
          $( "select[class|='GroupUID"+jam+"']" ).attr("id","GroupUID");

          $( ".Infobutton2").addClass(jam);
          $( ".CancelDelete").addClass(jam);


          $(".toptitles").addClass(jam);
          $("button").not("button[class*="+jam+"]").prop('disabled',true);

          // this jquery enables the text box when the button is pressed, it also sets an attribute to the ones that are selected, givving them the ID that will be used to send to the database 
          // var jam is used to store the value that is collected from the button 
          $("tr").not("tr[class*="+jam+"]").hide("slow"); // this only shows the field that you would want to edit
      });
  });
$(document).ready(function() // wait till the page is ready
{
    $(".Done").click(function() // wait till this button has been pressed
      { 
            var  jam =  $(this).val();
          $( "input[class*="+jam+"]" ).prop('disabled',true);
      });
  });
</script>



<script>
$(document).ready(function() // wait till the page is ready
{
    $(".CancelDelete").click(function() // wait till this button has been pressed
      { 
       $(".holder").load("ajax/Pages/Admin/ManageOwner.php");
      });
  });
</script>


<script>
  $('.Infobutton2').click(function() { //wait for the button to be pressed, this will need a name change 
     var val1 = $('#OwnerLocation').val(); // set val1 to the value in fullname
     var val2 = $('#GroupUID').val(); // set val 2 to the value in User Type
     var val3 = $('#Owner').val();

    
    if (val2 == '1' || val2 =='2' && val1 !== '') //check the values
    {
        $.ajax({ // now the ajax
        type: 'POST', // we are posting it 
        url: 'ajax/Pages/Admin/EditOwner.php', // this is where we're posting 
        data: { OwnerLocation: val1,GroupUID: val2, Owner: val3}, // set the php values
        success: function(response) { // this wont work lol, it does not need to, 
            $('#result').html(response);
            $('.phpechofront2').hide();
      $(".holder").load("ajax/Pages/Admin/ManageOwner.php");
        }
        });
    }
     else
     {
        $('.help').css( "color", "red" );
        $('.help').html("You are Missing a Value");
     };

});
</script>

