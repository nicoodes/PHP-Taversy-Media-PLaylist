


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="data">
	<input type="text" name="data2">
	<button type="submit">Submit</button>
</form>

<?php 
	
	///// Ceck for posted data
	// if (filter_has_var(INPUT_POST, "data")) {
	// 	echo "Data found";
	// } else {
	// 	echo "Data not found";
	// }


	///// Email validation
	// if(filter_has_var(INPUT_POST, "data")){
		
	// 	if(filter_input(INPUT_POST, "data", FILTER_VALIDATE_EMAIL)){
	// 			echo "Valid email";
	// 	} else {
	// 			echo "Please enter email";
	// 		}
				
	// }


	/// Email validation + sanitation
	// if(filter_has_var(INPUT_POST, "data")){
		
	// 	$email = $_POST["data"];

	// 	// Remove illegal chars

	// 	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	// 	echo $email. "<br>";


	// 	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
	// 			echo "Valid email";
	// 	} else {
	// 			echo "Please enter email";
	// 		}
				
	// }


	#FILTER_VALIDATE_BOOLEAN
	#FILTER_VALIDATE_EMAIL
	#FILTER_VALIDATE_FLOAT
	#FILTER_VALIDATE_INT
	#FILTER_VALIDATE_IP
	#FILTER_VALIDATE_REGEXP
	#FILTER_VALIDATE_URL

	#FILTER_SANITIZE_EMAIL
	#FILTER_SANITIZE_ENCODED
	#FILTER_SANITIZE_NUMBER_FLOAT
	#FILTER_SANITIZE_NUMBER_INT
	#FILTER_SANITIZE_SPECIAL_CHARS
	#FILTER_SANITIZE_STRING
	#FILTER_SANITIZE_URL


	//// Validate number
	// $var = 231;

	// if(filter_var($var, FILTER_VALIDATE_INT)){
	// 	echo "$var is a int number";
	// }else {
	// 	echo "$var is not a int number";
	// }

// $filters = array (
// 	'data' => FILTER_VALIDATE_EMAIL,
// 	'data2' => array(
// 			'filter' => FILTER_VALIDATE_INT,
// 			'options' => array(
// 					'min_range' => 1,
// 					'max_range'=> 100
// 				)
// 		)

// 	);

// print_r(filter_input_array(INPUT_POST, $filters));



$arr = array(
	'name' => 'nico odes',
	'age' => 36,
	'email' => 'nicoodes@gmail.com' 
);

$filters = array(
	'name' => array(
		'filter' => FILTER_CALLBACK,
		'options' => 'ucwords'	
		), 
	'age' => array(
		'filter' => FILTER_VALIDATE_INT,
		'options' => array(
			'min_range' => 1,
			'max_range' => 120	
			)
		),
	'email' => FILTER_VALIDATE_EMAIL
);

print_r(filter_var_array($arr, $filters));
 ?>