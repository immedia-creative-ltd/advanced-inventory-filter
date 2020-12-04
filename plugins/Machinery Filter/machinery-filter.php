<?php
/**
 * Plugin Name: Machinery Filter
 * Plugin URI: http://www.immedia-creative.com
 * Description: This plugin displays the machinery and elegantly filters fields shortcode machineryajax.
 * Version: 1.0.0
 * Author: Chris Brown
 * Author URI: http://www.immedia-creative.com
 * License: GPL2
 */
 

function machinery_enqueue_script() {  
	if( is_front_page() ){
	  wp_enqueue_script( 'machineryajax', plugin_dir_url( __FILE__ ) . '/machineryajax.js' ); 
	  wp_enqueue_script( 'getfilters', plugin_dir_url( __FILE__ ) . '/getfilters.js' );
	  wp_enqueue_script( 'machineryslider-js', plugin_dir_url( __FILE__ ) . 'assets/js/machineryslider.js' );
	}
	  wp_enqueue_style('machineryslider-css', plugin_dir_url( __FILE__ ) . 'assets/css/machineryslider.css');
}
add_action('wp_enqueue_scripts', 'machinery_enqueue_script');

function misha_my_load_more_scripts() {
 
	global $wp_query; 
 
	// register our main script but do not enqueue it yet
	//wp_register_script( 'lazyload', get_stylesheet_directory_uri() . '/assets/js/lazyload.js', array('jquery') );
 
	// now the most interesting part
	// we have to pass parameters to lazyload.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'lazyload', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script( 'lazyload' );
}
 
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


add_shortcode( 'machineryajax', 'machinery_ajax' );

function machinery_ajax(){ ?>

<?php
$thebrand ="";
if($_GET["thebrand"]){
$thebrand = htmlspecialchars($_GET["thebrand"]) ;}

$theprodtype ="";
if($_GET["theprodtype"]){
$theprodtype = htmlspecialchars($_GET["theprodtype"]) ;}

$thedivision ="";
if($_GET["thedivision"]){
$thedivision = htmlspecialchars($_GET["thedivision"]) ;}

$theclock ="";
if($_GET["theclock"]){
$theclock = htmlspecialchars($_GET["theclock"]) ;}

$theyear ="";
if($_GET["theyear"]){
$theyear= htmlspecialchars($_GET["theyear"]) ;}
		?>
	<div class="row filter-section">
	
		<div class="col-md-12">	
			<h2 style="color:#3d3d3b;">Find Your Machinery</h2>
		</div>
		
	</div>
	
	<div class="row" id="filter-fields">
		
		<div class="col-12 col-lg-6">	

			<div class="button-section">
					<div id="used" name="U" class="filter-button newused"><div class="button-text">Used</div><div class="line"></div></div>
					<div id="stockOffer" name="N" class="filter-button newused"><div class="button-text">Stock Offers</div><div class="line"></div></div>
					<div id="exhire" name="exhire" class="filter-button refinenew"><div class="button-text">Ex-Hire</div><div class="line"></div></div>
					<div id="exdemo" name="exdemo" class="filter-button refinenew"><div class="button-text">Ex-Demo</div><div class="line"></div></div>
			</div>
					
			   
			<div class="divisions-section" id="divisions-selection">
				<div class="wrap-cont">
					<div class="select-wrap">
						<select  name="divisions" id="divisions" class="selectpicker" title="Division" data-width="100%" data-dropup-auto="false">
							<option value="all" data-hidden="true">Divisions</option>
							<option class="ddgroup" value="all">All</option>
							<option <?php if($thedivision=="Agriculture"){echo " selected ";}?>class="ddagriculture"value="agriculture" >Agriculture</option>
                            <option  <?php if($thedivision=="Dairy"){echo " selected ";}?>value="dairy" class="dddairy">Dairy</option>
                            <option  <?php if($thedivision=="Construction"){echo " selected ";}?>value="construction" class="ddconstruction">Construction</option>
							<option  <?php if($thedivision=="Groundcare"){echo " selected ";}?>value="groundcare" class="ddgroundcare">Groundcare</option>
						</select>	
					</div>
				</div>
			</div>					

			<div class="machinerytype-section" id="machinerytype-section">
				<div class="wrap-cont">
					<div class="select-wrap <?php echo ($theprodtype);?>">
						<select name="machinerytype" id="machinerytype" multiple class="selectpicker" title="Machinery Type  &nbsp; (Multiple Select)" data-width="100%" data-dropup-auto="false">
							<option value="all">All</option>
							<?php
							$mycats = get_terms( 
							array(
							'taxonomy' => 'category',
							'hide_empty' => 1, 
							'orderby' => 'term_order'
							));
							foreach( $mycats as $mycat ) {
							echo '<option ';
							if ($mycat->name == $theprodtype){echo 'selected ';}
							echo 'value="'.$mycat->name.'">'.$mycat->name;
							echo '</option>';
							
							}
							?>
						</select>		
						
					</div>
				</div>
			</div>
			
			<div class="manufacturer-section" id="manufacturer-section">
				<div class="wrap-cont">
					<div class="select-wrap">
						<select name="manufacturer" id="manufacturer" size="1" multiple class="selectpicker" title="Manufacturer  &nbsp; (Multiple Select)" data-width="100%" data-dropup-auto="false">
							<option value="all">All</option>
							<?php
							$manufacturers = get_terms( 
							array(
							'taxonomy' => 'makes',
							'hide_empty' => 1, 
							'orderby' => 'term_order'
							));	
								foreach( $manufacturers as $manufacturer ) {
									
								echo '<option ';
								if ($manufacturer->name == $thebrand){echo 'selected';}
							     echo ' value="'.$manufacturer->name.'" >'.$manufacturer->name;
								echo '</option>';
								
									}
							?>
						</select>		
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="col-12 col-lg-6">		
						
			<div class="clock-section">
				<div class="wrap-cont">
					<div class="select-wrap">
						<select name="clock" id="clock" class="selectpicker" title="Clock" data-width="100%" data-dropup-auto="false">
							<option value="all" data-hidden="true">Clock</option>
							<option value="all">All</option>
							<option <?php if($theclock == "500"){echo " selected ";}?>value="500">Up to 500</option>
                            <option <?php if($theclock == "1500"){echo " selected ";}?>value="1500">Up to 1500</option>
                            <option <?php if($theclock == "3000"){echo " selected ";}?>value="3000">Up to 3000</option>
                            <option <?php if($theclock == "4500"){echo " selected ";}?>value="4500">Up to 4500</option>
                            <option <?php if($theclock == "7000"){echo " selected ";}?>value="7000">Up to 7000</option>
                            <option <?php if($theclock == "10000"){echo " selected ";}?>value="10000">Up to 10,000</option>
                            <option <?php if($theclock == "20000"){echo " selected ";}?>value="20000">Up to 20,000</option>
                            <option <?php if($theclock == "30000"){echo " selected ";}?>value="30000">Up to 30,000</option>
                            <option <?php if($theclock == "40000"){echo " selected ";}?>value="40000">Up to 40,000</option>
                            <option <?php if($theclock == "50000"){echo " selected ";}?>value="50000">Up to 50,000</option>
                            <option <?php if($theclock == "60000"){echo " selected ";}?>value="60000">Up to 60,000</option>
                            <option <?php if($theclock == "70000"){echo " selected ";}?>value="70000">Up to 70,000</option>
                            <option <?php if($theclock == "80000"){echo " selected ";}?>value="80000">Up to 80,000</option>
                            <option <?php if($theclock == "90000"){echo " selected ";}?>value="90000">Up to 90,000</option>
                            <option <?php if($theclock == "100000"){echo " selected ";}?>value="100000">Up to 100,000</option>
                            
							
						</select>	
						
					</div>
				</div>
			</div>
					
					
			<div class="year-section">
				<div class="wrap-cont">
					<div class="select-wrap">
						<select name="year" id="year" class="selectpicker" title="Year" data-width="100%" data-dropup-auto="false">
							<option value="0" data-hidden="true">Year</option>
							<?php
								global $wpdb;
								$query = "SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'vm_year' ORDER BY meta_value + 0 DESC;";
								$years = $wpdb->get_results( $query );
								foreach( $years as $year ) {
									if( $year->meta_value > '1990' ) {
									echo '<option ';
									if ($year->meta_value == $theyear){echo ' selected ';};
									echo 'value="'.$year->meta_value.'" >From '.$year->meta_value;
									echo '</option>';
									}
								}
								echo'<option value="1990" >Before 1990</option>';
								echo'<option value="0" >All</option>';
							?>
						</select>	
						
					</div>
				</div>
			</div>       
				
			<div class="slider-cont">
				<div class="slider-section">
					<div id="slider-range"></div>
				</div>
				
				<div class="row slider-labels">
					<div class="col-xs-6 caption">
					  Min: <span id="sliderMin" name="sliderMin"></span>
					</div>
					<div class="col-xs-6 text-right caption">
					  Max: <span id="sliderMax" name="sliderMax"></span>
					  <?php
					  //The following finds the max price in DB used for slider value and default value
						global $wpdb;
						$query = "SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'vm_trd_price' ORDER BY meta_value;";
						$prices = $wpdb->get_results( $query );

						$finalprices = array();

						foreach( $prices as $price ) {
						array_push($finalprices,$price->meta_value);
						}
						$maxPrice = max($finalprices);
						echo '<input type="hidden" id="sliderMaxPrice" value="' . $maxPrice . '" />';
					?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<form>
						<input type="hidden" id="min-value" name="min-value" value="">
						<input type="hidden" id="max-value" name="max-value" value="">
					</form>
				</div>
				<div  class="col-8 col-sm-8">
				
					<button type="submit" id="btnSubmit">Display Selection</button>
			
				</div>
				<div  class="col-4 col-sm-4">
					<div  style="margin-top:8px; text-align:right;">
						<a class="reset" href="/">Reset</a>
				   </div>
				</div>
			</div>
		</div>	
	</div>
	<div class="row">
		
		<div class="col-md-12">
			<div id="filter-accordion"><hr /></div>
		</div>
	</div>
	

	
<div class="row">
	<div class="col-md-12">		
		<div class="divider-wrapper" style="visibility:hidden;background-color:">
			<div class="visible-xs" style="height:12px;"></div>
			<div class="visible-sm" style="height:12px;"></div>
			<div class="visible-md" style="height:12px;"></div>
			<div class="visible-lg" style="height:12px;"></div>			
		</div>
	</div>
</div>
	
   	<div class="row info-row swatch-white">

		<div class="col-md-6">
		</div>
        
		<div class="col-md-6"> 
			<div class="wrap-cont filter-cont">
				<label for="sortby"> Sort By </label>
				<select name="sortby" id="sortby" class="selectpicker" title="Filter By" data-width="100%" data-dropup-auto="false">
					<option value="sortRecent">Date Added</option>
					<option value="sortPrice">£ Low to High</option>
                    <option value="sortHilow">£ High to Low</option>
                    <option value="sortYearnew">Newest to Oldest</option>
                    <option value="sortYearold">Oldest to Newest</option>		
				</select>		
			</div>
		</div>
		
	</div>
		
	<div class="row" style="padding-top:24px;">

			<div id="machinery-filter-response">
				<?php //include( plugin_dir_path( __FILE__ ) . 'getdata.php'); ?>
			</div>
	
	</div>
		
    </div>
<?php       
wp_reset_postdata();
 return $string;
  }  
?>