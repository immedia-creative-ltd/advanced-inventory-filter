<?php  
// make sure wp itself is available
if ($_REQUEST["ajax"]){include("../../../wp-load.php");}
 
function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function console_log( $data ){
  $out .= '<script>';
  $out .= 'console.log('. json_encode( $data ) .')';
  $out .='</script>';
}

//if we receive the 'mach'

if (isset($_GET['mach'])) {
	$mach = check_input($_GET['mach']);
	console_log($mach);
//set up args
	 $args = array(	
	 'post_type' => 'product',
	 'post_status' => 'publish',
	 'posts_per_page' => '-1',
	 'tax_query' => array(
			array(
			  'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $mach
     ))
	 );
	 //query all prods in chosen division
	 $query = new WP_Query( $args );
if($query->have_posts()){
	$posts = $query->get_posts();
	$namearray = array();
	 $sortednamearray = array();
	foreach ($posts as $post){
	//	loop through each, adding its machinery type to an array
			// get division name for class
		$terms = get_the_terms( $post->ID , 'makes' );
		//$terms = array_unique($terms);
	//$out = var_dump($terms);

		foreach ( $terms as $term ) {
		
		$termname = $term->name;
		//add to namearray
		array_push($namearray, $termname);
		

		}

			
	}
	$namearray = array_unique($namearray);
	
	$categories = get_categories( array(
	 'taxonomy' => 'makes',
	 'post_type' => 'product',
    'orderby' => 'term_order',
    'order'   => 'ASC'
) );
	
	
	//if it appears in  $namearray add it to sortednamearray
	foreach ($categories as $category){
	if (in_array($category->name, $namearray)) {
		array_push($sortednamearray, $category->name);
	}
		
	}	
	
	
	
	foreach($sortednamearray as $name){
		$options .= '<option value="'.$name.'">'.$name.'</option>';
	}
	
}
		
	else {
		$out = "no results";
	} 
	 


//add their machinery types to an array
//loop through array outputting the form select html 	

//class="selectpicker" should be on the select below

	$fixedouttop = '
	<div class="wrap-cont">
		<div class="select-wrap">
			<select name="manufacturer" id="manufacturer"  multiple class="selectpicker" title="Manufacturer  &nbsp; (Multiple Select)" data-width="100%" data-dropup-auto="false" onchange="setVariables()">';
	$fixedoutmiddle = $options;					
	$fixedoutbottom ='	
			</select>	
		</div>
	</div>		
	';
	

$out .=  $fixedouttop;
$out .=  $fixedoutmiddle;
$out .=  $fixedoutbottom;
    echo $out;
}

else {echo ("<p>error</p>");}
?>