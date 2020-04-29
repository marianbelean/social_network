	<?php

		$con = mysqli_connect('localhost','root','root');

		if(!$con)
		{
			echo 'Not Connected to Server';
		}
		if(!mysqli_select_db($con,'retea_soc'))
		{
			echo 'DB Not Selected';
		}
		$reg= strip_tags(@$_POST['reg']); //adaugat buton submit
		
		$First_Name="";
		$Last_Name="";
		$Username="";
		$Email="";
		$Email2="";
		$Password="";
		$Password2="";
		$d="";
		$u_check="";
		
		$First_Name = strip_tags(@$_POST['fname']);
		$Last_Name = strip_tags(@$_POST['lname']);
		$Username = strip_tags(@$_POST['username']);
		$Email = strip_tags(@$_POST['email']);
		$Email2 = strip_tags(@$_POST['email2']);
		$Password = strip_tags(@$_POST['password']);
		$Password2= strip_tags(@$_POST['password2']);
		$d= date("d-m-Y"); //sign-up date day-month-year
		$u_check= " "; //check if username exists
		
		
		if ($reg) 
		{
			if($Email==$Email2) 
			{
				$u_check= mysqli_query($con,"SELECT Username FROM retea WHERE Username= '$Username' ");
				$check= mysqli_num_rows ($u_check);
				if($check == 0)
					{
					if($First_Name&&$Last_Name&&$Username&&$Email&&$Email2&&$Password&&$Password2)
					{ 
						if ( $Password==$Password2 )
							{							
								if(strlen($Username)>25||strlen($First_Name)>25||strlen($Last_Name)>25) 
								{
									echo "The maximum limit for Username/First Name/Last Name is 25 charachters!";
								}	
								else
								{
									if(strlen($Password)>30 || strlen($Password)<8)
									{
										echo "Your password must be between 8 and 30 charachters long!";
									}
									
									else
									{
										$Password= md5($Password);
										$Password2= md5($Password2);
										$query= mysqli_query($con,"INSERT INTO retea VALUES ('','$Username','$First_Name','$Last_Name','$Email','$Password','$d','0')");
										die("<h2>Welcome to We_Friends</h2> Login to your account to get started...");
									}
								}
							}
							else 
							{
								echo "Your password doesn't match!";
							}
					}
						else
						{
						   echo "Please fill in all fields";
						}
					}
					else 
					{
						echo "Username already taken...";
					}
			}
				else
				{
					echo "Your E-mails don't match!";
				}
		}
if(isset($_POST["user_login"]) && isset($_POST["password_login"]))
	{
		$user_login=preg_replace('#[^A-Za-z0-9]#i','',$_POST["user_login"]);
		$password_login=preg_replace('#[^A-Za-z0-9]#i','',$_POST["password_login"]);
		$password_login_md5=md5($password_login);
	}
 $sql=mysqli_query($con,"SELECT id FROM retea WHERE username='$user_login' AND password='$password_login' LIMIT 1");
 $userCount=mysqli_num_rows($sql);
	if($userCount==1)
	{
		while($row=mysqli_fetch_array($sql))
		{
			$id=$row["id"];
		}
		$_SESSION["user_login"]=$user_login;
		exit();
	}
	else
	{
		echo 'That information is incorrect, try again';
		exit();
	}
}
	?>
