<?php
/**
 * Template Name: Single Product Template
 *
 * @file           single-product.php
 * @package        Sportback
 * @author         Chris Brown
 */



// ~ --------- ~ //

get_header(); ?>

<?php the_post(); ?>

      <?PHP
		if( get_field('pre_desc')=="MISCELLANEOUS"){
		$mytitle= get_field('alt_title') ;}
		else{$mytitle = get_the_title();}
	





///////
		// get division name for class
		$terms = get_the_terms( $post->ID , 'divisions' );
		foreach ( $terms as $term ) {
		$thedivision = $term->name;
	
		}
		
				// get category for similar products
		$mycats = get_the_terms( $post->ID , 'category' );
		foreach ( $mycats as $mycat ) {
		$mycatname = $mycat->name;
	
		}
////////

?>

	
<div id="thisisSingle-Product">
	<div id="content" role="main">


		
		<div class="vertical-ribbon used"></div>
		<div class="top-corner-piece"></div>
        <div class="go-off-the-screen used">
		
			<div class="container">
					<div class="row">  
					<div class="col-12 col-md-8"> 
						<h1 class="singleprod"><?php echo ($mytitle); ?></h1> 
					</div>
					<div class="col-12 col-md-4 shareandprint"> 
						<p class="share-print">
							<a data-toggle="modal" data-target="#shareModal" id="ga-open-share-modal">
								<i class="fa fa-share" aria-hidden="true"></i>
								Share
							</a>  
							&nbsp;  &nbsp;  <a href="#" onclick="window.print();return false;" style="color:#fff;"><img src="/wp-content/uploads/2020/09/printicon-w.png" alt="print this page" /> Print</a>
						</p>
					</div>
					</div>
			</div>
		
		
		</div>
		
     <div class="row introduction-bar" style="margin-bottom:24px;">   
     <div class="col-sm-12 col-md-2 intro-price <?php echo $thedivision;?>"><?php $price = get_field('vm_trd_price');
					$price = number_format($price);
					if ($price == "0"){echo '<span class="price singleprod">£ POA</span>';}
					else{
					echo  ' <span class="price singleprod">£'.$price.'</span><span class="vat"> ex VAT</span>';
					}?></div>
                    
                    <?php if( get_field('vmstok') ): ?>
    <div class="col-sm-12 col-md-3 intro-section <?php echo $thedivision;?>">STOCK REF: <span class="big singleprod"><?php the_field('vmstok'); ?></span></div>
					<?php endif; ?>
                    
                     <?php if( get_field('branch') ): ?>
   <div class="col-sm-12 col-md-3 intro-section <?php echo $thedivision;?>">BRANCH: <span class="big singleprod"><?php the_field('branch'); ?></span></div>
					<?php endif; ?>
                    
                    
                      <?php if( get_field('srp_name') ): ?>
    <div class="col-sm-12 col-md-4 intro-section <?php echo $thedivision;?>">CONTACT: <span class="big singleprod"><?php the_field('srp_name'); ?></span></div>
					<?php endif; ?>
              </div>      
       
          <div class="row">   
           <div class="col-md-6" style="padding-left:0px;"> 
           <?php
		   	// choose corner flash
		$date1 = date('Y-m-d', strtotime(get_the_date())) ;
		$date2 = date('Y-m-d', strtotime("-2 day"));	
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
		} elseif ( $date1 >= $date2){
		$showflash = 1;
		$flashmsg = "New In";
		}
		 if ($showflash == 1){
	
	 echo   '<div class="ribbon ribbon-top-left '.$thedivision.'">';
		echo  '<span';
	if ($flashmsg == "Reserved"){echo (' class="Reserved" ');}
		echo'>'.$flashmsg.'</span>';
	 echo   '</div>';
	}
		   ?>
          <script>
		  function showImage(thesource){
			var bigpic = document.getElementById('mainimage');
        bigpic.innerHTML = "<img src='"+thesource+"' style='width:100%; height:auto;' />";
		  }
		  
		  </script> 
           
          <?php if( has_post_thumbnail( $post_id ) ){ ?>
    <div class="post-image room-gallery" id="mainimage">
        <img title="mainimage"  alt="thumb image" class="wp-post-image gallery-highlight" 
             src="<?=wp_get_attachment_url( get_post_thumbnail_id() ); ?>" style="width:100%; height:auto;">
    </div>
		<?php  }
		 else{echo '<img src="/wp-content/uploads/2020/08/300x200-placeholder.png" alt="image to follow" style="width:100%" />';} ?>
         
        	<?php 
			//additional images
         	$images =& get_children( array (
		'post_parent' => $post->ID,
		'post_type' => 'attachment',
		'post_mime_type' => 'image'
	));

	if ( empty($images) ) {
		// no attachments here
	} else {
		echo "<div class='room-preview'>";
		$count= 0;
		foreach ( $images as $attachment_id => $attachment ) {	
			$image_attributes = wp_get_attachment_image_src( $attachment_id, 'medium_large' );
if ( $image_attributes ) {?>
    <img src="<?php echo $image_attributes[0]; ?>" width="93px" height="85px"  class="extraimage" onClick="showImage('<?php echo $image_attributes[0]; ?>')" />
<?php } 
			
		}
		echo "</div>";
	}
         
      ?>   
       
        
         <?php
	 	$myterms = get_the_terms( $post->ID, 'makes' );	
		$makeimage = get_field('image', $myterms[0]);
		$maketitle = $myterms[0]->name; 
		?> 
        <?php 	if ($makeimage<>""){
			// put make image here	
			echo  '<div class="brand-image" style="text-align:center;margin-top:20px;"><img src="'. $makeimage['url'].'" alt="brand logo" style="width:168px;"></div>';	
			} else {
			echo  '<div class="brand-image" style="text-align:center;margin-top:20px;"><img src="/wp-content/themes/sportback/assets/images/th-logos/thwusedlogo.png" alt="placeholder"></div>';
			}  ?> 
         </div>  
    
   
       <div class="col-md-6"> <!--r-sub1 column //-->  
       
  	
	<?php
		echo ("<p>MAKE: <span class='big singleprod'>".$maketitle."</span></p>"); ?> 
               
                       
            <?php if( get_field('vmmodl') ): ?>
    <p>MODEL: <span class='big singleprod'><?php the_field('vmmodl'); ?></span></p>
					<?php endif; ?>  
                    
                <?php if( get_field('vm_year') ): ?>
    <p>YEAR: <span class='big singleprod'><?php the_field('vm_year'); ?></span></p>
					<?php endif; ?>                 
                    
             <?php if( get_field('vm_wsj_clk') ): ?>
    <p>CLOCK: <span class='big singleprod'><?php the_field('vm_wsj_clk'); ?></span></p>
					<?php endif; ?> 
                    
                 <?php if( get_field('vm_engine') ): ?>
    <p>ENGINE: <span class='big singleprod'><?php the_field('vm_engine'); ?></span></p>
					<?php endif; ?> 
  
                   <?php if( get_field('vm_condition') ): ?>
    <p>CONDITION: <span class='big singleprod'><?php the_field('vm_condition'); ?></span></p>
					<?php endif; ?> 
        <hr />
        <h3>Product Specification</h3>
        <p><?PHP echo(get_the_content())?><p>
       
        <h3>Contact details</h3>   
       <?php if( get_field('srp_name') ): ?>
    <p style="font-weight:bold;text-transform:uppercase;"><?php the_field('srp_name'); ?></p>
		<?php endif; ?>
      <?php if( get_field('branchaddress') ): ?>
    <p><?php the_field('branchaddress'); ?></p>
		<?php endif; ?>             
     <?php if( get_field('dep_postcode') ): ?>
    <p><?php the_field('dep_postcode'); ?></p>
		<?php endif; ?> 
       <?php if( get_field('srp_mobile') ): ?>
    <p><img src="/wp-content/uploads/2020/10/phone22.png" alt="phone" /> <a href="tel:<?php the_field('srp_mobile'); ?>"><?php the_field('srp_mobile'); ?></a></p>
		<?php endif; ?>                 
	  </div>
       
       </div>
       <style>
	   form#contactseller{padding:20px;}
	   form#contactseller input,form#contactseller textarea{
		   width:100%; 
		   margin-bottom:10px;
		   border:solid 1px #cbd3da;
		   padding:5px 0 5px 10px;
		   }
		   
		 form#contactseller textarea {width:100%; max-width: 100%; height:auto;}
		 
		 form#contactseller input[type=button]{background-color:#5F839D; color:#fff; padding:10px; font-size:17px; font-family:"FSElliotHeavy",sans-serif;text-transform:uppercase;}
		 form#contactseller #submit:hover{background-color:#d9e2e8;color:#5F839D;}
	   </style>
        <form id="contactseller" action="<?php echo htmlspecialchars("#");?>"  method="post">
    <div class="row contacttheseller" style="background-color:#f4f8fb;">
    
        <div class="col-md-12">
            
            <h2 style="text-align:center; margin-top:20px;">CONTACT SELLER</h2> 
        </div>
        
            <div class="col-md-6">
            
                <input name="name" id="name" type="text" maxlength="40" placeholder="name (required)" value="<?php echo $cust_name;?>"/>
               <input name="email"  id="email"  type="text" maxlength="60" placeholder="email (required)" value="<?php echo $cust_email;?>"/>
               <input name="address"  id="address"  type="text" maxlength="250" placeholder="address" value="<?php echo $cust_address;?>" />
               <input name="postcode"   id="postcode" type="text" maxlength="30" placeholder="postcode" value="<?php echo $cust_postcode;?>" />
               <input name="tel"  id="tel"  type="text" maxlength="30" placeholder="telephone" value="<?php echo $cust_tel;?>" />
               <input type="hidden" name="stockref" id="stockref" value="<?php echo (the_field('vmstok'));?> "/>
                <input type="hidden" name="productname" id="productname" value="<?php echo ($mytitle);?> "/>
                 <input type="hidden" name="recipient" id="recipient" value="<?php echo (the_field('srp_email'));?> "/>
               </div>
               <div class="col-md-6">
               <textarea name="message"   id="message" cols="" rows="9" placeholder="message"><?php echo $cust_message;?></textarea>
                </div>
               <div class="col-md-12">
               <input name="submit" type="button" id="enquirysubmit" value="submit" />
              <p style="text-align:center;">The information requested on this contact form will be used to administer your enquiry into the purchase of this item. It may be shared with colleagues within the organisation.</p>
               	</div>
                </div>
                 </form>
               
                <div id="mailresponse"> </div>
               
               
               <div class="row similaritems">
                <div class="col-md-12">
              <h3>Other items you may be interested in...</h3> 
              </div> 
              
              
              <?php 
			  
              // Default arguments for similar items
$simargs = array(
     'post_type' => 'product',
     'post_status' => 'publish',
	'posts_per_page' => 3, // How many items to display
	'post__not_in'   => array( get_the_ID() ), // Exclude current post
	'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
	'tax_query' => array( 'relation' => 'AND',
        array(
            'taxonomy' => 'divisions',
            'field'    => 'name',
            'terms'    => $term->slug
        ),array(
            'taxonomy' => 'category',
            'field'    => 'name',
            'terms'    => $mycat->slug
        )
    )
);
//echo ("<p>");
//echo ($term->slug);
//echo (" - ");
//echo ($mycat->slug);
//echo ("</p>");
// Check for current post division and add tax_query to the query arguments

// Query posts
$wpex_query = new WP_Query( $simargs );
//if fewer than three dump this query and do a looser one
//echo ("A: ".$wpex_query->post_count);
if($wpex_query->post_count <=2){wp_reset_postdata();
$simargs = array(
     'post_type' => 'product',
     'post_status' => 'publish',
	'posts_per_page' => 3, // How many items to display
	'post__not_in'   => array( get_the_ID() ), // Exclude current post
	'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
	'tax_query' => array( 
        array(
            'taxonomy' => 'divisions',
            'field'    => 'slug',
            'terms'    => $term->slug
        )
    )
);
// Check for current post division and add tax_query to the query arguments
// Query posts
$wpex_query = new WP_Query( $simargs );
 //echo ("B: ".$wpex_query->post_count);
 }
              
    
        if ( $wpex_query->have_posts() ) {
            while ( $wpex_query->have_posts() ) {	
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
		$terms = get_the_terms( $wpex_query->ID , 'divisions' );
		foreach ( $terms as $term ) {
		$thedivision = $term->name;
	
		}
				
				//choose the title

                $wpex_query->the_post();          
              if( get_field('pre_desc')=="MISCELLANEOUS"){
		$mytitle= get_field('alt_title') ;}
		else{$mytitle = get_the_title();}
		
				// choose corner flash
		$showflash = 0;
	// choose corner flash
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
		} elseif ( $date1 >= $date2){
		$showflash = 1;
		$flashmsg = "New In";
		}
		   
              ?>
              
          
              <?php 
			
				?>
                  <div class="col-md-4 <?php echo $thedivision; ?> <?php echo $thedivision; ?><?php echo $mycatname; ?>"> 
            <a href="<?php  echo get_the_permalink(); ?>"><div class="productblock <?php echo $thedivision; ?>">
              <?php 
			if($showflash == 1){
				?>
            <div class="ribbon ribbon-top-left <?php echo $thedivision; ?>">
             <?php 	echo  '<span';
	if ($flashmsg == "Reserved"){echo (' class="Reserved" ');}
		echo'>'.$flashmsg.'</span>'; ?>  
            </div> 
              <?php 
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
        <div class="titlebox"><h3 style="text-align:center;"><?php echo $mytitle; ?></h3></div>
        <div class="detailsgroup"><div><span class="year-display"><?php echo get_field('vm_year')?></span><span class="hspacer"> | </span><span class="results-field-title"> Clock </span><span class="clock-display"><?php echo get_field('vm_wsj_clk');?></span></div>
        <div><span class="results-field-title">Condition </span><span class="condition-display"><?php echo get_field('vm_condition') ?></span></div></div>
        
        <div class="logogroup"><div class="inner"><?php //display make logo at max 90x90px(pull thumbnnail see http://zahlan.net/blog/2012/06/categories-images/)
					$myterms = get_the_terms( $post->ID, 'makes' );	
					$makeimage = get_field('image', $myterms[0]);

					if ($makeimage<>""){
						// put make image here	
						echo  '<img src="'. $makeimage['url'].'" alt="brand logo">';	
					} else {
					echo  '<img src="/wp-content/themes/sportback/assets/images/th-logos/thwusedlogo.png" alt="placeholder">';
					}  ?></div></div>
                    
                    <div class="pricegroup"><div class="pricebox <?php echo $thedivision; ?>">
					<?php $price = get_field('vm_trd_price');
					$price = number_format($price);
					if ($price == "0"){echo '£ POA';}
					else{
					echo  ' £'.$price.'<span class="vats"> ex VAT</span>';
					}?></div></div></div></a>
                
				 </div>
			 <?php	  
			 
		 	}}
	
              ?>
                 </div> 
                 
                 
             
          </div>    
     
  <div style="overflow:visible;">
     	<div class="bottom-corner-piece"></div>
        <div class="foot-off-screen used"></div>
    </div> 
     
     
	</div><!-- #content -->
</div><!-- #container -->

<div class="modal fade in" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="shareModalLabel">Share Product</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo do_shortcode( '[contact-form-7 id="4166" title="Share"]' ); ?>
                    </div>
					<div class="modal-footer">
						<?php echo do_shortcode('[Sassy_Social_Share]'); ?>
                    </div>
                </div>
            </div>
        </div>
	
<?php

get_footer();
