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
                  
                  <?php 
                  /* 
                    <div class="caption"><?php echo t('!p Corporate Info:', array('!p' => '<span property="v:itemreviewed">' . $node->field_p_name['und'][0]['value'] . '</span>')); ?></div> 
                  */ ?>
                  <div><?php echo '<div class="title">' . t('Founded') . ':</div>' . $node->p_data['info']['i_founded']; ?></div>
                  <div><?php echo '<div class="title">' . t('Headquarters') . ':</div><div property="v:address">' . $node->p_data['info']['i_heads'] . '</div>'; ?></div>
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
                echo '<div id="overview" class="text">', render($content['body']);
                
                if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                    echo '<div class="site">' , vr_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value']) , '</div>';
                  }  
                echo '</div><div class="bottom-clear"></div><div id="pricing" class="text">' . $node->p_data['pricing_structure'] . '</div>';
                
                //echo '<div class="title">Customer Service</div><div class="text">' . $node->p_data['customer_service'] . '</div>';
                
                
                
                ?>
          
          
          
          
           

          
                      
              <div class="data tabs">
                
                
                
                <ul>
                  <?php 
                    if ($node->p_data['available_features']) { 
                      echo '<li><a href="#tabs-1">Available Features</a></li>'; 
                    } 
                  ?>
                  
                  <?php 
                    if (isset($content['vr_ratings']) && $content['vr_ratings']) { 
                      echo '<li><a href="#tabs-2">User Reviews & Ratings</a></li>'; 
                    } 
                  ?>
                  
                  <li><a href="#tabs-3"><?php echo 'Write Review'; ?></a></li>
                </ul>
                
 
                
                
                
                
                <?php 
                    if ($node->p_data['available_features']) { 
                      echo '<div id="tabs-1">',
                         $node->p_data['available_features'],
                         '<div class="bottom-clear"></div></div>'; 
                    } 
                ?>
                
                
                
                <?php if (!empty($content['vr_ratings'])): ?>
                
                    <div id="tabs-2">

                          <div class="votes_overall">
                            <?php 
                              $stars_overall = theme('vr_misc_fivestar_static', array('rating' => $node->vr_rating_overall * 20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css')));
                              echo '<div class="rating_overall"><span class="title">Rating: ' . $node->vr_rating_overall . ' out of 5</span>' . $stars_overall . '</div>';
                              echo '<div class="voters"><div class="title">' . 'Number of Reviews' . ':</div><div class="count" property="v:count"><a href="#reviews">' . $node->vr_voters . '</a></div></div>';
                              echo '<div class="recommend"><div class="title">' . t('Would recommend') . ': </div><div class="data">' . $node->vr_recommend . '% of Users' . '</div></div>'; 
                            ?>
                          </div>


                        <?php if (!empty($content['reviews_entity_view_1'])): ?>
                            
                            <div class="reviews">
                              <div class="header">
                                <h2><?php echo $node->field_p_name['und'][0]['value'], ' User Reviews' ?></h2>
                                <a id="reviews"></a>
                              </div>

                              <?php echo render($content['reviews_entity_view_1']); ?>

                            </div>
                        <?php endif;  ?>


                      <div class="bottom-clear"></div>

                    </div>
                
                <?php endif; // end of if ($page && isset($content['vr_ratings']) && $content['vr_ratings']): ?>
                
                
                
                <div id="tabs-3">
                  
                  <div id="write-revew-header">
                    
                    <div class="votes_overall">
                      <?php 
                        if (!empty($node->vr_rating_overall)) {
                          $stars_overall = theme('vr_misc_fivestar_static', array('rating' => $node->vr_rating_overall * 20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css')));
                          echo '<div class="rating_overall"><span class="title">Rating: ' . $node->vr_rating_overall . ' out of 5</span>' . $stars_overall . '</div>';
                          echo '<div class="voters"><div class="title">Number of Reviews:</div><div class="count" property="v:count">' . $node->vr_voters . '</div></div>'; 
                          echo '<div class="recommend"><div class="title">Would recommend: </div><div class="data">' . $node->vr_recommend . '% of Users' . '</div></div>'; 
                        }
                        else {
                          echo '<div class="rating_overall NA"><span class="title">Rating: N/A</span></div>';
                          echo '<div class="voters NA"><div class="title">Number of Reviews: </div><div class="count">N/A</div></div>'; 
                          echo '<div class="recommend NA"><div class="title">Would recommend: </div><div class="data">N/A</div></div>'; 
                        }
                      ?>
                    </div>
                  </div>

                  <?php 
                  
                    echo $node->addProviderReviewForm;
                  
                  ?>
                  
                  <div class="bottom-clear"></div>
                </div>
                
                
              </div> <?php  // End of <div class="data tabs"> ?>
              
          <?php echo render($content['metatags']); //vr_misc_renderMetatags_newOrder($content['metatags']);?>
          
          
              
              
              
              
          <?php else: ?> <!-- if !$page -->
          
              <?php
                if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                  echo '<div class="logo">' . theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page')) . '</div>';
                }
              ?>
          
              <?php echo render($content['body']); ?>
          
          <?php endif; ?>  <!-- if ($page): -->
           
        </div> <!-- content -->
  

  </div> <!-- main-content -->
  
    
<?php if (!$page): ?>
  </article> <!-- /.node -->
<?php endif; ?>
