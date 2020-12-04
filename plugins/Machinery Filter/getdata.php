<?PHP
function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_REQUEST["ajax"]){include("../../../wp-load.php");}

$divisions = "all";
if ($_REQUEST["divisions"]){$divisions = check_input($_REQUEST["divisions"]);}

$machinerytype = "all";
if ($_REQUEST["machinerytype"]){$machinerytype = $_REQUEST["machinerytype"];}

//Change string to array
$machinerytypeArray = explode(',', $machinerytype);

$manufacturer = "all";
if ($_REQUEST["manufacturer"]){$manufacturer = check_input($_REQUEST["manufacturer"]);}
//Change string to array
$manufacturerArray = explode(',', $manufacturer);

$clock = "all";
if ($_REQUEST["clock"] || $_REQUEST["clock"]=='0'){
$clock = check_input($_REQUEST["clock"]);
}

$year = "all";
if ($_REQUEST["year"] || $_REQUEST["year"]=='0'){
$year = check_input($_REQUEST["year"]);
}

$sliderMin = "0";
if ($_REQUEST["sliderMin"]){
$sliderMin = check_input($_REQUEST["sliderMin"]);
}

$sliderMax = $maxPrice;
if ($_REQUEST["sliderMax"]){
$sliderMax = check_input($_REQUEST["sliderMax"]);
}

$sortby = "sortRecent";
if ($_REQUEST["sortby"]){
$sortby = check_input($_REQUEST["sortby"]);
}

$used = "";
if ($_REQUEST["used"]){
$used = "1";
}

$stockOffer = "";
if ($_REQUEST["stockOffer"] == "N"){
$stockOffer = "1";
}

$exhire = "";
if ($_REQUEST["exhire"] == "exhire"){
$exhire = "1";
}

$exdemo = "";
if ($_REQUEST["exdemo"] == "exdemo"){
$exdemo = "1";
}

//Used for testing PHP variables
/*
echo  '<div>';
echo '<div>PHP Variables</div>';
echo '<div>used value is ' . $used. '</div>';
echo '<div>stock offer value is ' . $stockOffer . '</div>';
echo '<div>exhire value is ' . $exhire . '</div>';
echo '<div>exdemo value is ' . $exdemo . '</div>';
echo '<div>divisions value is ' . $divisions . '</div>';
echo '<div>machinerytype value is ' . $machinerytype . '</div>';
echo '<div>machinerytype array is ' . print_r($machinerytypeArray) . '</div>';
echo '<div>manufacturer value is ' . $manufacturer . '</div>';
echo '<div>manufacturer array is ' . print_r($manufacturerArray) . '</div>';
echo '<div>clock value is ' . $clock . '</div>';
echo '<div>year value is ' . $year . '</div>';
echo '<div>sliderMin value is ' . $sliderMin . '</div>';
echo '<div>sliderMax value is ' . $sliderMax . '</div>';
echo '<div>sortby value is ' . $sortby . '</div>';
echo  '</div>';
*/

//sanitize

if (strlen($divisions) >= 40){echo ("Error: Sorry, divisions not found");die;}	

$tax_query = array('relation' => 'AND');

if ( $divisions != 'all'){
        $tax_query[] =  array(
            'taxonomy' => 'divisions',
            'field' => 'slug',
            'terms' => $divisions
        );
}


if ( $machinerytype != 'all'){
        $tax_query[] =  array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $machinerytypeArray
        );
}

if ( $manufacturer != 'all'){
        $tax_query[] =  array(
            'taxonomy' => 'makes',
            'field' => 'slug',
            'terms' => $manufacturerArray
        );
}






$meta_query = array('relation' => 'AND');
//add button to query
 




if ( $clock != 'all'){
        $meta_query[] =  array(
            'key'		=> 'vm_wsj_clk',
			'value'	=> $clock,
			'type'		=> 'NUMERIC',
			'compare'	=> '<='
        );
}

if ( $year != 'all' && $year !='1990'){
        $meta_query[] =  array(
            'key'		=> 'vm_year',
			'value'	=> $year,
			'type'		=> 'NUMERIC',
			'compare'	=> '>='
        );
}
if ( $year =='1990'){
        $meta_query[] =  array(
            'key'		=> 'vm_year',
			'value'	=> $year,
			'type'		=> 'NUMERIC',
			'compare'	=> '<='
        );
}

		//price range is always active so no need to check if set
        $meta_query[] =  array(
            'key'		=> 'vm_trd_price',
			'value'	=> $sliderMin,
			'type'		=> 'NUMERIC',
			'compare'	=> '>='
        );
		
		$meta_query[] =  array(
            'key'		=> 'vm_trd_price',
			'value'	=> $sliderMax,
			'type'		=> 'NUMERIC',
			'compare'	=> '<='
        );

if ( $sortby == 'sortType' ) {	
	
	$metaKey = 'vgdes';
	$orderBy = 'meta_value';
	$order = 'ASC';	

} elseif ( $sortby == 'sortManufacturer' ) {

	$metaKey = 'pre_desc';
	$orderBy = 'meta_value';
	$order = 'ASC';	
	
} elseif ( $sortby == 'sortRecent' ) {

	//meta key must be empty
	$metaKey = '';
	$orderBy = 'date';
	$order = 'ASC';
	
} elseif ( $sortby == 'sortPrice' ) {

	$metaKey = 'vm_trd_price';
	$orderBy = 'meta_value_num';
	$order = 'ASC';	
	
} else {
	
	//meta key must be empty
	$metaKey = '';
	$orderBy = 'date';
	$order = 'ASC';
	
}

//echo $metaKey;
//echo $orderBy;
//echo $order;
	
$args = (array(
		'post_type' => 'product',
        'post_status' => 'publish',
       'posts_per_page' => '-1',
		'meta_key' => $metaKey,
        'orderby' => 'term_order'  , 
        'order' => $order, 
		'tax_query' => $tax_query,
		'meta_query' => $meta_query
	
	 ));

	
$query = new WP_Query( $args );

// query number 2

// build second query

$meta_query2 = array('relation' => 'OR');

if ( $used == "1"){ $meta_query2[] =  array(
           'key'		=> 'vmnu',
			'value'	=> 'U'
      );
}

if ( $stockOffer == "1"){ $meta_query2[] =  array(
           'key'		=> 'stockoffers',
			'value'	=> 1
      );
}

if ($exhire == "1"){ $meta_query2[] =  array(
            'key'		=> 'ex_hire',
			'value'	=> 1
        );
}

if ($exdemo == "1"){$meta_query2[] =  array(
            'key'		=> 'ex_demo',
			'value'	=> 1
        );
}

$args2 = (array(
		'post_type' => 'product',
        'post_status' => 'publish',
       'posts_per_page' => '-1',
		'meta_query' => $meta_query2
	
	 ));
$query2 = new WP_Query( $args2 );

$q1posts = $query->posts; //an array of all query1 results
$q2posts = $query2->posts; //an array of all query2 results

$q1postsid = array();//an empty array of all query1 ids
$q2postsid = array();//an empty array of all query2 ids

foreach ($q1posts as $id )
{array_push($q1postsid,$id->ID); // add to query1 ids
}

foreach ($q2posts as $q2id )
{array_push($q2postsid,$q2id->ID); // add to query2 ids 
}

$q3postsid = array_intersect ($q1postsid , $q2postsid ); // join the two lists of ids

if (count($q3postsid) == 0){
	$countout= "<span style='color:#e1001a;'>No adverts found. Please reselect.</span>";
	
}
else{$countout= count($q3postsid);}

	echo '<div class="info-row">';
				echo '<div class="col-md-6">';
					echo '<div id="division-info" class="filter-info">Division: ' . $divisions . '</div>';
		echo '<div id="total-info" class="filter-info">Products: ' .$countout .'</div>';
				echo '</div>';
			echo '</div>';
			echo '<div id="filter-results">';
////////////////////////////////
///////////////////////////////ok, we have a list of ids, but unsorted. We want them in the order of makes
//so now go get the makes that have items
	$catargs = array(
    'hide_empty' => true, 
);
$catterms = get_terms('category', $catargs);

//var_dump($catterms);  //yes, this works! Leave this line it here for testing

//We have the makes in order 



foreach ($catterms as $catterm){


// the args for the subloop should inclue a taxonomy query for the makes terms

  $myargs = array('post_type' => 'product', 
                   'post__in' => $q3postsid,
				   'posts_per_page' => '-1',
				   'tax_query' => array(
				  					 array(
								  'taxonomy' => 'category',
								   'field' => 'term_id',
								  'terms' => $catterm->term_taxonomy_id
								 )
								 ),
				   'orderby' => $orderBy, 
                   'order' => $order );
  
   $myposts = new WP_Query($myargs);


		//$total = $query->found_posts;
		$total1 = $query->found_posts;
		$total2 = $query2->found_posts;
		$total3 = $myposts->found_posts;
		
		
	
	
	
		
		
		
		
		
	
	  // Start looping over the query results.
    while ( $myposts->have_posts() ) {
		
 
        $myposts->the_post();
		
		$date1 = date('Y-m-d', strtotime(get_the_date())) ;
		$date2 = date('Y-m-d', strtotime("-2 day"));
		$stock_status = get_field('stock_status');
		$vmnu = get_field('vmnu');
		$vmstat = get_field('vmstat');
		$advertising_status = get_field('advertising_status');
		$one = '1';
		$stock_status =  strtoupper($stock_status);
		$vmnu =  strtoupper($vmnu);
		$vmstat =  strtoupper($vmstat);
		
		// get division name for class
		$terms = get_the_terms( $post->ID , 'divisions' );
		foreach ( $terms as $term ) {
		$thedivision = $term->name;
		}
		
		//choose whether title or alt title to be displayed?
	
	if( get_field('pre_desc')=="MISCELLANEOUS"){
		$mytitle= get_field('alt_title') ;}
		else{$mytitle = get_the_title();}
		
		// choose corner flash
		$showflash = 0;
		if (get_field('due_in')=="1"){
			$showflash = 1;
		$flashmsg = "Due In";
		} elseif (get_field('ex_hire')=="1"){
			$showflash = 1;
		$flashmsg = "Ex Hire";
		} elseif  ((get_field('ex_demo')=="1") ) {
		$showflash = 1;
		$flashmsg = "Ex Demo";
		}  elseif  ((get_field('ex_display')=="1") ) {
			$showflash = 1;
		$flashmsg = "Ex Display";
		}  elseif  ((get_field('reserved')=="1") ) {
			$showflash = 1;
		$flashmsg = "Reserved";
		} 	elseif ( $date1 >= $date2){
		$showflash = 1;
		$flashmsg = "New In";
		}
		
		
		//OUTPUT THE BOXES

echo " \r\n";
echo "\r\n <!-- // --> ";	
echo " \r\n";
echo '<div class="col-sm-12 col-md-6 col-lg-4 machinery-filter-col">';
	
	
	  
	echo   '<a href="'.get_the_permalink().'">';
	 
		echo   '<div class="productblock '.$thedivision.'">';
		 if ($showflash == 1){
	 echo   '<div class="ribbon ribbon-top-left '.$thedivision.'">';
	echo  '<span';
	if ($flashmsg == "Reserved"){echo (' class="Reserved" ');}
		echo'>'.$flashmsg.'</span>';
	 echo   '</div>';
	}
					?> 
					<div class="imagegroup"> 
					<?PHP 
						if ( has_post_thumbnail() ) {
						   echo (the_post_thumbnail('prod-list-image'));
						} else {
							//echo ('<img src="/wp-content/plugins/machinery-filter/assets/placeholder.png" alt="no image"  />');
							$img= wp_get_attachment_image_src('3643', 'prod-list-image'); 
							$imgSrc = $img[0];
							
							echo ('<img src="' . $imgSrc . '" class="attachment-prod-list-image size-prod-list-image wp-post-image" alt="no image" width="330" height="220">');
						}
						
							echo  '<div class="refnumberbox">';
						echo  '<span class="ref-field-title">REF: </span><span class="results-field">'.get_field('vmstok').'</span>';
						echo  '</div>';
						
						?>
					</div>
        <?PHP
			echo  '<div class="titlebox">';
				echo '<h3 style="text-align:center;">'.$mytitle.'</h3>';
			echo  '</div>';
		
		

		
			echo  '<div class="detailsgroup">';

		
				echo  '<div>';
					echo  '<span class="year-display">'.get_field('vm_year').'</span>';
					if (get_field('hide_clock')=="hide"){}
					else{
					echo  '<span class="hspacer"> | </span>';
					echo  '<span class="results-field-title"> Clock </span>';
					echo  '<span class="clock-display">'.get_field('vm_wsj_clk').'</span>';
					}
				echo  '</div>';
			
				echo  '<div>';
					echo  '<span class="results-field-title">Condition </span>';
					echo  '<span class="condition-display">'.get_field('vm_condition').'</span>';
				echo  '</div>';
		
			echo  '</div>';
		

			echo  '<div class="logogroup" >';
			
				echo  '<div class="inner" >';
				
					//display make logo at max 90x90px(pull thumbnnail see http://zahlan.net/blog/2012/06/categories-images/)
					$myterms = get_the_terms( $post->ID, 'makes' );	
					$makeimage = get_field('image', $myterms[0]);

					if ($makeimage<>""){
						// put make image here	
						echo  '<img src="'. $makeimage['url'].'" alt="brand logo">';	
					} else {
					echo  '<img src="/wp-content/themes/sportback/assets/images/th-logos/thwusedlogo.png" alt="placeholder">';
					}
					
				echo  '</div>';
			echo  '</div>';
		
		
				
			echo  '<div class="pricegroup">';
			
				echo  '<div class="pricebox '.$thedivision.'">';
					$price = get_field('vm_trd_price');
					$price = number_format($price);
					if ($price == "0"){echo '£ POA';}
					else{
					echo  ' £'.$price.'<span class="vats"> ex VAT</span>';
					}
				echo  '</div>';
				
				
				
			echo  '</div>';
		
		echo  '</div>';
		
	echo'</a>';
	
echo '</div>
	';
        // Contents of the queried post results go here.



} 

}

echo'</div>';
?>


<?php 
  if ( $query->max_num_pages > 1 ) {
	echo '<a href="?page=2" class="misha_loadmore">More posts</div>'; // you can use <a> as well
}
wp_reset_postdata(); 


?>
