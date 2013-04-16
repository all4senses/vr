<div id="c-top">

    <header id="header" role="banner" class="clearfix">

    <nav id="navigation" role="navigation" class="clearfix">
      
      
      <div id="logo-block">
        <a href="<?php print $front_page; ?>" title="<?php print 'VoIP Rater Home'; ?>" id="logo">VoIP Rater</a>
        <div id="header-caption">2013 Best VoIP Provider Reviews. VoIP Service Ratings and Discount Codes</div>  
      </div>
      
      <?php 
          global $user;

          echo render($page['header']); 
          
          echo vr_blocks_getBlockThemed(array('module' => 'om_maximenu', 'delta' => 'om-maximenu-1', 'no_subject' => TRUE, 'class' => 'block-om-maximenu', 'shadow' => FALSE), TRUE, '+31 day', ($user->uid ? '_logged' : NULL));
          
//          if (in_array('administrator', $user->roles) || in_array('writer', $user->roles)) {
//            echo '<a id="e" title="Edit content..." href="/admin/content-vr">e</a>';
//          }
      ?>
    </nav> <!-- /#navigation -->

    <?php ////if ($breadcrumb): print $breadcrumb; endif;?>
  </header> <!-- /#header -->

</div>




    
  <?php
  /*
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div>
  */
  ?>

  

  
  <?php if ($page['highlighted']): ?>
    <section id="highlighted" class="clearfix">
      <?php print render($page['highlighted']); ?>
    </section>
  <?php endif; ?>
  
  <div id="all-content-wrapper">
  <div id="all-content" class="clearfix">
      
      
    
      <section id="main" role="main" class="clearfix">

          <?php 
            if ($breadcrumb): 
              print $breadcrumb; 
            endif;
          ?>
        
          <?php 
          
            print $messages; 
            // we aren't getting messages, get them manually
//            if (isset($_SESSION['messages'])) {
//                echo '<div class="messages">';
//                foreach($_SESSION['messages'] as $type=>$messages) {
//                    echo "<p class=\"$type\">".implode("</p><p class=\"$type\">", $messages)."</p>";
//                }
//                echo '</div>';
//                unset($_SESSION['messages']);
//            }

            
          ?>
          <a id="main-content"></a>
          
          <?php /* if (!$is_front && $title): ?>
            <?php print render($title_prefix); ?>
            <h1 class="title" id="page-title"><?php print $title; ?></h1>
            <?php print render($title_suffix); ?>
          <?php endif; */ ?>
          
          <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          
          <?php print render($page['above_content']); ?>
          <?php print render($page['content']); ?>
          
          <?php 
          //global $user;
//          $pages_with_timestamp = array(
//            '/compare-business-voip-providers', 
//            '/business-voip-reviews', 
//            '/compare-residential-voip-providers', 
//            '/best-voip-service-providers',
//            '/residential-voip-reviews', 
//            '/sip-trunking-providers',
//            '/internet-fax-service-providers',
//            '/providers/reviews', 
//            '/about-voip-services', 
//            '/blog', 
//            '/news', 
//            '/voip-provider-submit-user-review',
//            '/about-us',
//            '/contact-us',
//            '/advertise',
//            '/press',
//            '/privacy-policy',
//            '/terms-of-use',
//            '/our-team',
//          );
//          //if ($user->uid == 1) {
//          if($is_front || in_array($_SERVER['REDIRECT_URL'], $pages_with_timestamp))
//            echo vr_misc_lastUpdatedStamp();
              
          //}
          ?>
          
      </section> <!-- /#main -->


      <?php if ($page['sidebar_first']): ?>
        <aside id="sidebar-first" role="complementary" class="sidebar clearfix">
          <?php print render($page['sidebar_first']); ?>
        </aside>  <!-- /#sidebar-first -->
      <?php endif; ?>

      <?php if ($page['sidebar_second']): ?>
        <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
          <?php print render($page['sidebar_second']); ?>
        </aside>  <!-- /#sidebar-second -->
      <?php endif; ?>

        
  </div> <!-- /#all-content -->
</div>
  

  
  <footer id="footer" role="contentinfo" class="clearfix">
    <div id="footer-inside">

      <!--<div id="in-touch"></div> -->

      <div class="c">© 2004-2013 VoIP Rater</div>
      
      <?php 
        echo render($page['footer']);
        
        //echo vr_blocks_getBlockThemed(array('module' => 'vr_blocks', 'delta' => 'send_msg_n_subscribe', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        //echo vr_blocks_getBlockThemed(array('module' => 'vr_blocks', 'delta' => 'social_links', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        echo vr_blocks_getBlockThemed(array('module' => 'vr_blocks', 'delta' => 'footer_links', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        
        //echo '<div id="block-vr-blocks-follow-links"><div class="follow-us">Follow Us</div>', vr_blocks_get_headerLinks(), '</div>';
      ?>
      
      
    </div>
  </footer> <!-- /#footer -->

