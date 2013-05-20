<?php if (!$page): ?>

    <?php if (in_array('administrator', $user->roles)): ?>
      <div class="tabs-wrapper clearfix"><h3 class="element-invisible">Primary tabs</h3>
        <ul class="tabs primary clearfix">
          <li class="active"><a class="active" href="/<?php echo $_GET['q']; ?>">View<span class="element-invisible">(active tab)</span></a></li>
          <li><a href="<?php echo url('node/' . $node->nid . '/edit', array('query' => array('destination' => $_GET['q']))); ?>">Edit</a></li>
          <!--<li><a href="<?php //echo url('node/' . $node->nid . '/devel', array('query' => array('destination' => $_GET['q']))); ?>">Devel</a></li>-->
        </ul>
      </div>
    <?php endif; ?> <!-- if (in_array('administrator', $user->roles))-->
  
<?php endif; ?> <!-- if (!$page) -->
    

  <?php 
      
      // Define if this page should contain G+ provile link and authorship,
      // And if it's a ALL reviews page.
      //$pages_with_gplus_author = array('/providers/reviews', '/news', '/blog');
      $pages_with_gplus_author_keys = array('front', 'view-reviews-page_all_reviews', 'view-news-page', 'view-blog-page');
      $current_is_reviews = FALSE;
      $current_is_with_gplus_author = FALSE;
      
      if (isset($node->field_preface_key['und'][0]['value']) && in_array($node->field_preface_key['und'][0]['value'], $pages_with_gplus_author_keys)) {
      //if (isset($_SERVER['REDIRECT_URL']) && in_array($_SERVER['REDIRECT_URL'], $pages_with_gplus_author)) {
        $current_is_with_gplus_author = TRUE;
        //if ($_SERVER['REDIRECT_URL'] == '/providers/reviews') {
        if ($node->field_preface_key['und'][0]['value'] == 'view-reviews-page_all_reviews') {
          $current_is_reviews =  TRUE;
        }
      }
  

        $url = 'http://www.voiprater.com' . ($_GET['q'] == 'home' ? '' : $_SERVER['REQUEST_URI']);
        
        $share_title = NULL;
                
        if ($is_front) {
          $share_title = vr_misc_metatag_getFrontTitle();
        }

        if (!$share_title) {
          if (isset($node->metatags['title']['value']) && $node->metatags['title']['value']) {
            $share_title = $node->metatags['title']['value'];
          }
          else {
            $share_title = $title;
          }
        }

        echo '<div class="float share">' . vr_blocks_getSocialiteButtons($url, $share_title) . '</div>';
      ?>

    <h1 class="preface" <?php /*echo preg_replace('/datatype=""/', '', $title_attributes);*/ if ($current_is_reviews) {echo ' property="dc:title v:summary"';} else {echo preg_replace('/datatype=""/', '', $title_attributes);} ?>>
        <?php 
          echo $title; 
          // Add G+ provile link and authorship for some pages.
          if ($current_is_with_gplus_author) {
            echo ' <a title="Google+ profile" href="https://plus.google.com/u/0/111924926980254330731?rel=author"></a>';
          }
        ?>
    </h1>



  <?php if ($display_submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

  <div class="content page preface" 
    <?php 
    echo $content_attributes;
//    if ($current_is_reviews) {
//      echo ' xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate"';
//    }
  ?>>
    
    <?php
//      if ($current_is_reviews) {
//        echo '<div id="all-reviews-snippet">Total of <span id="count" property="v:count">99</span> Reviews for all <span id="itemreviewed" property="v:itemreviewed">VoIP Providers</span><span class="rating-descr" style="display: none;">, with top rating of <span id="rating" property="v:rating">5</span></span>';
//      }
      
      // Hide comments, tags, and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      
      echo render($content['body']);
      
      if (@$node->field_display_type['und'][0]['value'] != 1) {
        hide($content['field_preface_bottom']);
      }
      
      
      
      // Create a banner rotator on the home page from the field_preface_middle data.
      if (@$node->field_preface_key['und'][0]['value'] == 'front') {
        
        //dpm($content);
        
        hide($content['field_preface_middle']);
        
        drupal_add_library('system', 'ui.core');
        drupal_add_library('system', 'ui.widget');
        drupal_add_library('system', 'ui.tabs');

        $path_to_custom_js = drupal_get_path('module', 'vr_misc') . '/js/';
        drupal_add_js($path_to_custom_js . 'vr_homeBannerRotator.js');

        $path_to_current_theme = drupal_get_path('theme',$GLOBALS['theme']) . '/css/';
        drupal_add_css($path_to_current_theme . 'vr_bannerRotator.css');

        $ui_tabs_nav = '';
        $fragments = '';
        $middles = element_children($content['field_preface_middle']);
        foreach ($middles as $key) {
          
          foreach($content['field_preface_middle'][$key]['entity']['field_collection_item'] as $value) {
            $ui_tabs_nav .= '<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-' . $key . '"><a href="#fragment-' . $key . '">' . $value['field_preface_b_title'][0]['#markup'] . '</a></li>';
            $fragments .= '<div id="fragment-' . $key . '" class="ui-tabs-panel"><div class="info">' . $value['field_preface_b_body'][0]['#markup'] . '</div></div>';
            
            break; // Here should be just one item, but with an undefined key.
          }
          
        }
        $key += 1; 
        dpm($key);
        $blog_tab = '<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-' . $key . '"><a href="#fragment-' . $key . '">Blog</a></li>';
        $blog_fragment = '<div id="fragment-' . $key . '" class="ui-tabs-panel"><div class="info">Blog content</div></div>';
        echo '<div id="featured"><ul class="ui-tabs-nav">', $ui_tabs_nav, $blog_tab, '</ul>', $fragments, $blog_fragment, '</div>';
        dpm(vr_misc_getHomeBlogPostsForBannerRotator());
      }

      
      print render($content);
    
    ?>
      
  </div>
