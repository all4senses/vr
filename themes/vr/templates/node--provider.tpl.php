<?php if (!$page): ?>
  <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
<?php endif; ?>

           
  <div class="main-content" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
    
        <?php if ($page): ?>
    
    
          <?php

            $url = 'http://www.voiprater.com'. url('node/' . $node->nid);
            echo '<div class="float share">' . vr_blocks_getSocialiteButtons($url, $node->title) . '</div>';

          ?>
    
    
          <h1<?php //print $title_attributes; 
                //echo 'property="dc:title v:summary"'; 
                echo ' property="v:summary"'; 
                if (!$node->status) {echo ' class="not-published"';}?> ><?php 
                  print $title; //t('Our Take on !p Business VoIP Provider', array('!p' => $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/) )
                ?></h1>
   
   
        <?php else: ?>
          <header>
        
            <h2<?php //print $title_attributes; ?> property="dc:title v:summary">
                <a href="<?php print $node_url; ?>">
                  <?php print $title; ?>
                </a>
            </h2>
            
          </header>
        <?php endif; ?>
    

    

        <div class="content"<?php print $content_attributes; ?>>
          
          
          
           <?php if ($page): ?>
          
              <div id="basic-info" rel="v:itemreviewed">
                
                <?php
                  if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                    echo '<div class="logo">' . vr_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page', 'alt' => $content['field_p_logo'][0]['#item']['alt'], 'title' => $content['field_p_logo'][0]['#item']['title'], 'attributes' => array('rel' => 'v:photo')))), '</div>';
                  }
//                  if (isset($content['field_p_image'][0]['#item']['uri'])) {
//                    echo '<div class="image">' . vr_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_image'][0]['#item']['uri'], 'style_name' => 'image_provider_page', 'alt' =>  $content['field_p_image'][0]['#item']['alt'], 'title' =>  $content['field_p_image'][0]['#item']['title']))), '</div>';
//                  }
                ?>
                
                <div id="organization" typeof="Organization">
                  
                  <div class="caption"><?php echo t('!p Corporate Info:', array('!p' => '<span property="v:itemreviewed">' . $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/ . '</span>')); ?></div>
                  <div><?php echo '<div class="title">' . t('Headquarters') . ':</div><div property="v:address">' . $node->p_data['info']['i_heads'] . '</div>'; ?></div>
                  <div><?php echo '<div class="title">' . t('Founded In') . ':</div>' . $node->p_data['info']['i_founded']; ?></div>
                  <div><?php echo '<div class="title">' . t('Service Availability') . ':</div>' . $node->p_data['info']['i_availability']; ?></div>
                  <div>
                    <?php 
                      if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                        $goto_link_title = (isset($node->p_data['info']['i_web_display']) && $node->p_data['info']['i_web_display']) ? $node->p_data['info']['i_web_display'] : str_replace(array('http://', 'https://'), '', $node->p_data['info']['i_web']);
                        echo '<div class="title">' . t('Website') . ':</div>' . vr_misc_getTrackingUrl($goto_link_title, NULL, NULL, NULL, NULL, array('key' => 'rel', 'value' => 'v:url'));
                      }
                      ?>
                  </div>
                  
                </div>
                
              </div>
          
          

                    <?php /*if (!empty($node->p_data['ereview']['editor_rating_overall']))*/ { ?>
                  
                        <div class="pros-and-cons">
                            <?php 
                            if (!empty($node->p_data['ereview']['pros_and_cons']['Advantages'])) {
                              echo '<div class="title">Advantages</div><div class="text">' . $node->p_data['ereview']['pros_and_cons']['Advantages'] . '</div>'; 
                            }
                            if (!empty($node->p_data['ereview']['pros_and_cons']['Disadvantages'])) {
                              echo '<div class="title">Disadvantages</div><div class="text">' . $node->p_data['ereview']['pros_and_cons']['Disadvantages'] . '</div>';
                            }
                            if (!empty($node->p_data['ereview']['pros_and_cons']['Verdict'])) {
                              echo '<div class="title">Verdict</div><div class="text">' . $node->p_data['ereview']['pros_and_cons']['Verdict'] . '</div>';
                            }
                            ?>
                        </div>

                      <?php /*
                        <div class="vr_votes editor">
                          <?php $editor_overall_rating = number_format($node->p_data['ereview']['editor_rating_overall'] * 0.05, 1); ?>
                          <?php echo '<div class="caption"><span><span property="v:reviewer">Editor</span>\'s Overall Rating:</span> <span property="v:rating">' , $editor_overall_rating, '</span>' , '<div class="bottom-clear"></div></div>' , render($node->editor->content['vr_ratings']); ?>
                          <div class="rate-other">
                            <div class="text"><?php echo '<div class="title">' . t('Recommend') . ': </div><div class="data">' . $node->editor->vr_recommend . '</div>'?></div>
                            <?php echo '<div class="voters editor"><div class="count" property="v:count">' . (!empty($node->vr_voters) ? $node->vr_voters : 1) . '</div></div>';?>
                          </div>
                        </div>
                        */
                      ?>

                  <?php } ?>
              

                  
              <?php
                echo '<div class="text">', render($content['body']);
                if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                    echo '<div class="site">' , vr_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value']) , '</div>';
                  }  
                echo '</div>';
                
                echo '<div class="title">Pricing Structure</div><div class="text">' . $node->p_data['pricing_structure'] . '</div>';
                echo '<div class="title">Customer Service</div><div class="text">' . $node->p_data['customer_service'] . '</div>';
                if ($node->p_data['available_features']) { echo '<div class="title">Available Features</div><div class="text">' . $node->p_data['available_features'] . '</div>'; }
                
                ?>
          
          
          
          
           <div class="bottom-clear"></div>

              <?php if (isset($content['vr_ratings']) && $content['vr_ratings']): ?>

                  <div class="vr_votes">
                    <?php 
                      ////echo '<div class="caption">' . t('Overall Consumer Ratings') . '</div>' . render($content['vr_ratings']); 
                    
                      $stars_overall = theme('vr_misc_fivestar_static', array('rating' => $node->vr_rating_overall * 20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css')));
                      echo '<div class="rating_overall">' . $stars_overall . ' <div class="count">(' . $node->vr_rating_overall . ')</div>';

                    ?>
                  </div>
                  <div class="overall">
                    <div class="text">
                      <?php echo '<a id="write-review" href="/voip-provider-submit-user-review?id=' . $node->nid . '"><img src="/f/img/writeareview.png" /></a><div class="voters"><div class="title">' . 'Number of Reviews' . ':</div><div class="count" property="v:count"><a href="#reviews">' . $node->vr_voters . '</a></div></div>'; ?>
                      <?php //echo render($content['vr_recommend']); ?>
                      <?php echo '<div class="recommend"><div class="title">' . t('Would recommend') . ': </div><div class="data">' . $node->vr_recommend . '% of Users' . '</div></div>'; ?>
                      <div class="overall title"><?php $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/ . ' ' . t('Overall Rated:'); ?></div>
                    </div>
                    <div class="star-big">
                      <?php echo /*render($content['vr_rating_overall'])*/ '<div class="count" content="' . $node->vr_rating_overall . '" property="v:rating">' . $node->vr_rating_overall . '</div>' . '<div class="descr">' . t('Out of 5 stars') . '</div>'; ?>
                    </div>
                  </div>
              
              <? else: ?>
                  <?php echo '<a id="write-review" href="/voip-provider-submit-user-review?id=' . $node->nid . '"><img src="/f/img/writeareview.png" /></a>'; ?>
              <?php endif; // end of if ($page && isset($content['vr_ratings']) && $content['vr_ratings']): ?>
              
              <div class="bottom-clear"></div>
          
          
          
          <?php
                
                
                
                /*
              ?>
                      
              <div class="data tabs">
                
                
                
                <ul>
                  <li><a href="#tabs-1"><?php echo 'Review'; ?></a></li>
                  <?php 
//                    if (!empty($features)) {
//                      echo '<li><a href="#tabs-2">Quick Stats</a></li>
//                            <li><a href="#tabs-3">List Features</a></li>';
//                    }
                  ?>
                </ul>
                <div id="tabs-1">
                  <?php echo render($content['body']); ?>
                </div>
                <?php 
//                    if (!empty($features)) {
//                      echo '<div id="tabs-2"><div>', $quick_stats_out, '<div><span class="title">Plans:</span> ',  $plans, '</div></div></div>',
//                           //'<div id="tabs-3"><div class="title">List of Features Available on ' , $node->field_p_name['und'][0]['value'], '</div>', $features_out, '</div>';
//                           '<div id="tabs-3">', $features_out, '</div>';
//                    }
                ?>
                
                
                
              </div> <?php */ // End of <div class="data tabs"> ?>
              
          <?php echo render($content['metatags']); //vr_misc_renderMetatags_newOrder($content['metatags']);?>
          
          
              
              
              
              
          <?php else: ?> <!-- if ($page): -->
          
                <?php
                  if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                    echo '<div class="logo">' . theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page')) . '</div>';
                  }
                ?>
          
              <?php echo render($content['body']); ?>
          
          
          
          <?php endif; ?>  <!-- if ($page): -->
           
              
          <?php //echo render($content); ?>
          
        </div> <!-- content -->

        
        
      <?php if ($page): ?>
    
        <!--
        <footer>
        </footer>
        -->
        
      <?php endif; ?>
        
      

  </div> <!-- main-content -->
  
    
  
    
    <h2 class="button"><?php echo $node->field_p_name['und'][0]['value'], ' ', t('User Reviews'); ?></h2>
    <?php 

//      if (isset($node->current_user_has_review)) {
//        echo l(t('Your Review'), $node->current_user_has_review, array('attributes' => array('title' => t('You have already submitted a review for this provider: "' . $node->current_user_has_review_title . '"')))); 
//      }
//      else {
//        echo l(t('Submit Your Review'), 'node/add/review', array('query' => array('id' => $node->nid))); 
//      }

      
      echo $node->addProviderReviewForm;
    ?>
    
  
  
  <?php if ($page && isset($content['reviews_entity_view_1']) && $content['reviews_entity_view_1']): ?>
    <div class="reviews">
      <div class="header">
        <a id="reviews"></a>
        
        <!-- <div class="button"> -->
          <?php 
  
//            if (isset($node->current_user_has_review)) {
//              echo l(t('Your Review'), $node->current_user_has_review, array('attributes' => array('title' => t('You have already submitted a review for this provider: "' . $node->current_user_has_review_title . '"')))); 
//            }
//            else {
//              echo l('Submit Your Review', 'node/add/review', array('query' => array('id' => $node->nid))); 
//            }

          ?>
        <!--</div> -->
      </div>

      
      <?php 
        // Hide Sort be Select element.
        //<div class="form-item form-type-select form-item-sort-by">
        ////$content['reviews_entity_view_1'] = preg_replace('/(.*<div.*views-widget-sort-by.*\")(>.*)/', "$1 style=" . '"display: none;"' . "$2", $content['reviews_entity_view_1']);
      
      
//      <div class="views-exposed-widget views-widget-sort-order">
//        <div class="form-item form-type-select form-item-sort-order">
//          <label for="edit-sort-order">Order </label>
//          <select class="form-select" name="sort_order" id="edit-sort-order"><option value="ASC">Asc</option><option selected="selected" value="DESC">Desc</option></select>
//        </div>
//      </div>
    
//        if (strpos($content['reviews_entity_view_1'], '<option selected="selected" value="created">Post date</option>')) {
//          $content['reviews_entity_view_1'] = preg_replace('/(.*<option value="ASC">)(.*)(<.*)/', "$1xxx$3", $content['reviews_entity_view_1']);
//        }
//        else {
//          $content['reviews_entity_view_1'] = preg_replace('/(.*<option value="ASC">)(.*)(<.*)/', "$1yyy$3", $content['reviews_entity_view_1']);
//        }
        echo render($content['reviews_entity_view_1']); 
      ?>
      
    </div>
 <?php endif;  ?>
  

<?php if (!$page): ?>
  </article> <!-- /.node -->
<?php endif; ?>
