<?php


/**
 * Implements hook_preprocess_user_profile();
 */
/*
function vr_preprocess_user_profile(&$profile) {
  //dpm($profile);
}
*/


/**
 * Implements theme_link();
 * 
 * Add rel=nofollow to external links.
 */
function vr_link($variables) {
  
  if (strpos($variables['path'], '://') && !strpos($variables['path'], 'ttp://www.voiprater.com')) {
    
    if (empty($variables['options']['attributes']['rel'])) {
      $variables['options']['attributes']['rel'] = 'nofollow';
    }
    else {
      if(is_array($variables['options']['attributes']['rel'])) {
        $rels = '';
        foreach($variables['options']['attributes']['rel'] as $rel) {
          $rels .= ($rels ? ' ' : '') . $rel;
        }
        $variables['options']['attributes']['rel'] = $rels;
      }

      if (strpos($variables['options']['attributes']['rel'], 'nofollow') === FALSE) {
        $variables['options']['attributes']['rel'] .= ' nofollow';
      }

    }
  }
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}


/**
 * Implements hook_preprocess_user_picture();
 */
function vr_preprocess_user_picture(&$picture) {
  // Remove a link from a picture.
  if (!isset($picture['account']->picture->uri)) {
    return;
  }
  if (!empty($picture['account']->realname)) {
    $realname = $picture['account']->realname;
  }
  else {
    $userExtendedData = vr_misc_loadUserExtendedData($picture['account']->uid);
    $realname = $userExtendedData->realname;
  }
  $picture['user_picture'] = theme('image_style', array( 'path' =>  $picture['account']->picture->uri, 'style_name' => 'avatar_profile_page', 'alt' => $realname, 'title' => $realname, 'attributes' => array('rel' => 'v:photo')));
}


/**
 * Returns HTML for the "next page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move forward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vr_pager_next($variables) {
  // Add a next rel metatag.
  $out = theme_pager_next($variables);
  if ($out) {
    $out_altered = str_replace('&amp;', '&', $out);
    if(preg_match('|.*href="([^"]*)" .*title="([^"]*)" .*|', $out_altered, $matches) && !empty($matches[1])) {
      
      //dpm('out in next = ' . $out_altered);
      //dpm($matches);

      if ($matches[2] == 'Go to next page') {
        vr_misc_addMetatag('next', NULL, $href = 'http://www.voiprater.com' . $matches[1]);
      }
    }
  }
  return $out;
}


/**
 * Returns HTML for the "previous page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move backward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vr_pager_previous($variables) {
  // Add a prev rel metatag.
  $out = theme_pager_previous($variables);
  if ($out) {
    $out_altered = str_replace('&amp;', '&', $out);
    if(preg_match('|.*href="([^"]*)" .*title="([^"]*)" .*|', $out_altered, $matches) && !empty($matches[1])) {

      //dpm('out in prev = ' . $out_altered);
      //dpm($matches);
      
      if ($matches[2] == 'Go to previous page') {
        vr_misc_addMetatag('prev', NULL, $href = 'http://www.voiprater.com' . $matches[1]);
      }
      
    }
  }
  return $out;
}


/**
 * Returns HTML for a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to
 * retrieve a pager control so that users can view other results. Format a list
 * of nearby pages with additional query results.
 *
 * @param $variables
 *   An associative array containing:
 *   - tags: An array of labels for the controls in the pager.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *   - quantity: The number of pages in the list.
 *
 * @ingroup themeable
 */
function vr_pager($variables) {
  
  //dpm($variables);
  
  // Hide a pager on the home page.
//  if($_GET['q'] == 'home') {
//    return NULL;
//  }
  
  
//  $arg_0 = arg(0);
//  $arg_1 = arg(1);
//  $altered_pager_posts = array('user', 'news', 'blog', 'about-voip-services', 'taxonomy');
//  $altered_pager_reviews = array(98, 429, 434, 581); // 581 - /canada-voip, 434 - /residential-voip-reviews, 429 - /business-voip-reviews, 98 - /providers/reviews
//  
//  if ((in_array($arg_0, $altered_pager_posts) && $arg_1 != 'tags-admin') || @$_SERVER['REDIRECT_URL'] == '/articles') {
//    $newer_link_title = '‹ Newer Posts';
//    $older_link_title = 'Older Posts ›';
//  }
//  elseif ( $arg_0 == 'node' && (in_array($arg_1, $altered_pager_reviews) || vr_misc_identifyNodeType($arg_1) == 'provider') ) {
//    $newer_link_title = '‹ Newer Reviews';
//    $older_link_title = 'Older Reviews ›';
//  }
//  else {
//    return theme_pager($variables);
//  }
  
    $newer_link_title = '‹ Next Entries';
    $older_link_title = 'Previous Entries ›';

  
  
  
  
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : $newer_link_title), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : $older_link_title), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  
  if ($li_previous) {
    $items[] = array(
      'class' => array('pager-previous'),
      'data' => $li_previous,
    );
    
//    if(preg_match('|.*href="(.*)"\s.*|', $li_previous, $matches) && !empty($matches[1])) {
//      vr_misc_addMetatag('prev', NULL, $href = 'http://www.voiprater.com' . $matches[1]);
//    }
    
  }
  if ($li_next) {
    
    $items[] = array(
      'class' => array('pager-next'),
      'data' => $li_next,
    );
    
//    if(preg_match('|.*href="(.*)"\s.*|', $li_next, $matches) && !empty($matches[1])) {
//      vr_misc_addMetatag('next', NULL, $href = 'http://www.voiprater.com' . $matches[1]);
//    }

  }
  
  if (empty($items)) {
    return NULL;
  }
  else {
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' 
          . theme('item_list', array(
            'items' => $items,
            'attributes' => array('class' => array('pager')),
          ));
  }
  
  
  
  
  
  // Original.
  /*
  
  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
  */
}


/**
 * Implements hook_preprocess_search_results().
 */
function vr_preprocess_search_results(&$variables) {
  
//  // a4s - fix - show lost pager from the results page on some pages.
//  // need prior actions (hack) in function node_search_execute() at node.module
//  // v1
//  //doesn't work correctly - it create bad links like http://www.voiprater.com/search/node/sip%20trunking?page=0%2C0%2C0%2C0%2C0%2C0%2C0%2C1
//  $variables['pager'] = theme('pager', array('tags' => NULL, 'element' => 7));

  
  
  // a4s - fix - show lost pager from the results page on some pages.
  // need prior actions (hack) in function node_search_execute() at node.module
  // v2
  global $vr_num_rows, $vr_limit_rows;
//  dpm('$vr_num_rows =' . $vr_num_rows, '$vr_limit_rows = ' . $vr_limit_rows);
//  dpm($_SESSION['vr_node_search_data']);
//  $page = pager_default_initialize($_SESSION['vr_node_search_data']['vr_num_rows'], $_SESSION['vr_node_search_data']['vr_limit_rows']);
  $page = pager_default_initialize($vr_num_rows, $vr_limit_rows);
  $variables['pager'] = theme('pager', array('tags' => NULL));
 
}


/**
 * Implements hook_html_head_alter().
 * We are overwriting the default meta character type tag with HTML5 version.
 */
function vr_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
  
  // Set right order for main metatags.
  
  
  $head_elements['system_meta_content_type']['#weight'] = -8;
  
  
  if (isset($head_elements['metatag_description'])) {
    $head_elements['metatag_description']['#weight'] = -15;
  }
  if (isset($head_elements['description'])) {
    $head_elements['description']['#weight'] = -15;
  }
  if (isset($head_elements['metatag_keywords'])) {
    $head_elements['metatag_keywords']['#weight'] = -14;
  }
  if (isset($head_elements['keywords'])) {
    $head_elements['keywords']['#weight'] = -14;
  }
  if (isset($head_elements['news_keywords'])) {
    $head_elements['news_keywords']['#weight'] = -13;
  }

  
//  $c_title = drupal_get_title();
//  dpm($c_title);
  
  //dpm($head_elements);
  
  $current_page = NULL;
  
  // Remove a canonical tag if there next or prev tags are present.
  if (!empty($head_elements['next']) || !empty($head_elements['prev'])) {
    unset($head_elements['metatag_canonical']);
    
    
    // Define the number of a current page.
    if (!empty($head_elements['next'])) {
      $next = explode('?', $head_elements['next']['#attributes']['href']);
      //dpm($next);
      foreach (explode('&', $next[1]) as $param) {
        $param = explode('=', $param);
        if ($param[0] == 'page') {
          $current_page = ($param[1] - 1) + 1;
          break;
        }
      }
    }
    else {
      $prev = explode('?', $head_elements['prev']['#attributes']['href']);
      if (isset($prev[1])) {
        foreach (explode('&', $prev[1]) as $param) {
          $param = explode('=', $param);
          if ($param[0] == 'page') {
            $current_page = ($param[1] + 1) + 1;
            break;
          }
        }
      }
      else {
        $current_page = 2;
      }
      
      
    }

    if ($current_page > 1) {
      
      // Define a current page title
      if (!empty($head_elements['name']['#attributes']['content'])) {
        $current_title = $head_elements['name']['#attributes']['content'];
      }
      else {
        $current_title = drupal_get_title();
      }

      $current_title = str_replace(' | www.voiprater.com', '', $current_title);

      //dpm($current_title);

      global $altered_head_title;
      
      $altered_head_title = $current_title . ' - Page ' . $current_page . ' | VoIP Now';
      
      if (isset($head_elements['metatag_description'])) {
        $head_elements['metatag_description']['#value'] = 'Page ' . $current_page . ' - ' . $head_elements['metatag_description']['#value'];
      }
      if (isset($head_elements['description'])) {
        $head_elements['description']['#attributes']['content'] = 'Page ' . $current_page . ' - ' . $head_elements['description']['#attributes']['content'];
      }
      //dpm('$altered_head_title = ' . $altered_head_title);
//      global $user;
//      if ($user->uid == 1) {
//        vr_misc_addMetatag('title', $altered_head_title);
//      }
    }
  }
  
  // Add a OG:Description metatag
  if (!empty($head_elements['metatag_description']['#value'])) {
    $head_elements['metatag_og_description'] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
          'property' => 'og:description',
          'content' => $head_elements['metatag_description']['#value'],
      ),
    );
  }
  
  
  //dpm($head_elements);
  
}


/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function vr_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h3 class="element-invisible">' . t('Primary tabs') . '</h3>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h3 class="element-invisible">' . t('Secondary tabs') . '</h3>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}


/*
function vr_preprocess_breadcrumb(&$variables) {
  dpm($variables);
}
*/


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function vr_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $heading = '<h3 class="element-invisible">' . t('You are here') . '</h3>';
    // Uncomment to add current page to breadcrumb
	// $breadcrumb[] = drupal_get_title();
    return '<nav itemprop="breadcrumb" class="breadcrumb">' . $heading . implode(' » ', $breadcrumb) . '</nav>';
  }
}


/**
 * Override or insert variables into the page template.
 */
function vr_process_page(&$variables) {
  
  //$variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => drupal_get_breadcrumb()));
  //array(l(t('Home'), NULL), l(t('Blogs'), 'blog'), l(t("!name's blog", array('!name' => format_username($node))), 'blog/' . $node->uid))
  
  if(isset($variables['node'])) {
    $variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
  }
  elseif (arg(0) == 'get' && @arg(1) == 'iframe') {
    module_invoke('admin_menu', 'suppress');
    $variables['theme_hook_suggestions'][] = 'page__url__iframe';
  }
  

  
  // Set breadcrumb
  $tags_cloud_pages = array('/articles/tags', '/blog/tags', '/news/tags');
  $not_teasers_types = array('preface', 'admin_page', 'page', 'quote', 'webform');
  
  global $current_tag_title;
  
  //dpm($_SERVER);
  //dpm($_SERVER['REQUEST_URI']);
  
  //dpm($current_tag_title);
  //dpm(arg());
  
  if(@$_SERVER['REQUEST_URI'] == '/') {
    $variables['breadcrumb'] = ''; // Home page has no bredcrumb.
  }
  elseif(isset($variables['node']) && !in_array($variables['node']->type, $not_teasers_types) ) {
    //dpm($variables['node']);
    //dpm('not-teasers node------------');
    switch ($variables['node']->type) {
      case 'provider':
        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Providers', 'providers'), $variables['node']->field_p_name['und'][0]['value'] . ' Review')));
        break;
      case 'provider_type':
        if ($variables['node']->title == 'Usage') {
          $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Types Of VoIP', 'types'), $variables['node']->title)));
        }
        else {
          $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Types Of VoIP', 'types'), l('VoIP Usage', 'usage'), $variables['node']->title)));
        }
        break;
//      case 'review':
//        if (!empty($variables['node']->field_ref_provider['und'][0]['target_id'])) {
//          $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Providers', 'providers'), l($variables['node']->field_r_provider_name['und'][0]['value'] . ' Review', 'node/' . $variables['node']->field_ref_provider['und'][0]['target_id']), $variables['node']->title )));
//        }
//        else {
//          $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Providers', 'providers'), $variables['node']->title )));
//        }
//        break;
//      case 'phone':
//        //dpm($variables['node']);
//        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Reviews', 'providers/reviews'), l('VoIP Phone Reviews', 'voip-phone-reviews'), $variables['node']->title )));
//        break;
//      case 'phone_review':
//        //dpm($variables['node']);
//        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Reviews', 'providers/reviews'), l('VoIP Phone Reviews', 'voip-phone-reviews'), l($variables['node']->field_p_name['und'][0]['value'], 'node/' . $variables['node']->field_ref_phone['und'][0]['target_id']), $variables['node']->title )));
//        break;
      
//      case 'article':
//        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Articles', 'articles'), l('Library', 'about-voip-services'), $variables['node']->title )));
//        break;
      case 'blog_post':
        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Articles', 'articles'), $variables['node']->title )));
        break;
//      case 'news_post':
//        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Articles', 'articles'), l('News', 'news'), $variables['node']->title )));
//        break;
    }
  }
  /*
  elseif(in_array($_SERVER['REQUEST_URI'], $tags_cloud_pages)) {
    //dpm('Tags cloud page ------------');
    switch ($_SERVER['REQUEST_URI']) {
      case '/articles/tags':
        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Library articles', 'about-voip-services'), 'VoIP Library tags' )));
        break;
      case '/blog/tags':
        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Blog', 'blog'), 'Blog tags' )));
        break;
      case '/news/tags':
        $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('News', 'news'), 'News tags' )));
        break;
    }
  }
  */
  elseif($current_tag_title) {
    if (strpos($_SERVER['REQUEST_URI'], 'features/') != FALSE) {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Types Of VoIP', 'types'), l('VoIP Features', 'features'), $current_tag_title )));
    }
    elseif(strpos($_SERVER['REQUEST_URI'], 'equipment/') != FALSE) {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Types Of VoIP', 'types'), l('VoIP Equipment', 'equipment'), $current_tag_title )));
    }
    elseif (strpos($_SERVER['REQUEST_URI'], 'protocols/') != FALSE) {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Types Of VoIP', 'types'), l('VoIP Protocols', 'protocols'), $current_tag_title )));
    }
  }
  /*
  elseif(strpos($_SERVER['REQUEST_URI'], '/tags/') != FALSE) {
    //dpm('Tag page ------------');
    
    // Don't show anything yet.
    //$variables['breadcrumb'] = '';
    
    // Defined in
    global $current_tag_title;
  
    if(strpos($_SERVER['REQUEST_URI'], 'articles/tags/') != FALSE) {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('VoIP Library articles', 'about-voip-services'), l('Articles tags', 'articles/tags'), $current_tag_title )));
    }
    elseif (strpos($_SERVER['REQUEST_URI'], 'blog/tags/') != FALSE) {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('Blog', 'blog'), l('Blog tags', 'blog/tags'), $current_tag_title )));
    }
    else {
      $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('News', 'news'), l('News tags', 'news/tags'), $current_tag_title )));
    }

  }
  */
  elseif ($breadcrumb = vr_misc_getMenuTrail()) {
    //dpm('Page VIA MENU------------');
    $variables['breadcrumb'] = $breadcrumb;
  }
  elseif (isset($variables['node'])) {
    //dpm('Any other NODE page------------');
    $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), $variables['node']->title )));
  }
  elseif (@$_SERVER['REDIRECT_URL'] == '/voip-provider-submit-user-review') {
    //dpm('Any other NODE page------------');
    $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), 'Submit Provider Review' )));
  }
  elseif (@$_SERVER['REDIRECT_URL'] == '/voip-phone-submit-user-review') {
    //dpm('Any other NODE page------------');
    $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), 'Submit Phone Review' )));
  }
  elseif (arg(0) == 'user' && is_int($arg_uid = arg(1))) {
    //dpm('User profile page------------');
    $userExtendedData = vr_misc_loadUserExtendedData($arg_uid);
    $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => array(l('Home', NULL), l('About Us', 'about-us'), l('Our Team', 'our-team'), $userExtendedData->realname )));
  }
  else {
    //dpm('Any other NOT node page------------');
    $variables['breadcrumb'] = '';
  }
  
  
  // Set a user referer.
  $module_path_misc = drupal_get_path('module', 'vr_misc');
  drupal_add_js( $module_path_misc . '/js/vr_setReferer.js'); 
  
}


/**
 * Override or insert variables into the node template.
 */
function vr_preprocess_node(&$variables) {
  $variables['submitted'] = t('Published by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  if(isset($variables['node'])) {
    
    if($variables['node']->type == 'blog_post' || $variables['node']->type == 'news_post') {
      $variables['theme_hook_suggestions'][] = 'node__article';
    }
    elseif($variables['node']->type == 'webform') {
      $variables['theme_hook_suggestions'][] = 'node__admin_page';
    }
    
    elseif($variables['node']->type == 'preface') {
      // Speed test page have its own template
      if (@$variables['node']->field_preface_key['und'][0]['value'] == 'voip-speed-test') {
        $variables['theme_hook_suggestions'][] = 'node__preface__voip_speed_test';
      }
      // Custom 404 page.
      elseif(@$variables['node']->field_preface_key['und'][0]['value'] == 'page-not-found') {
        $variables['theme_hook_suggestions'][] = 'node__preface__page404';
      }
      // Types of providers page.
      elseif(@$variables['node']->field_preface_key['und'][0]['value'] == 'providers_types_n_features_n_etc') {
        $variables['theme_hook_suggestions'][] = 'node__preface__types';
      }
    }
    
  }
  
}


/**
 * Preprocess variables for region.tpl.php
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function vr_preprocess_region(&$variables, $hook) {
  // Use a bare template for the content region.
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__bare';
  }
}


/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function vr_preprocess_block(&$variables, $hook) {
  // Use a bare template for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__bare';
  }

  $variables['title_attributes_array']['class'][] = 'block-title';
}


/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function vr_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Changes the search form to use the "search" input element of HTML5.
 */
function vr_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}

/**
 * Changes the search button label. Here... because it doesn't work via module hook.
 */
function vr_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    
    // Hide a word on the button "Search"
    ///$form['actions']['submit']['#value'] = '';
    
    // Autohiding hint.
    $default_search_text = t('Search VoIP Rater');
    $form['search_block_form']['#default_value'] = $default_search_text;
    $form['default_text']['#default_value'] = $default_search_text;
    // Cause a fatal error without it for anonymous.
    $form['default_text']['#type'] = 'hidden';
    
    
    // Example! Does NOT work!!! The above one works!
    //$form['search_block_form']['#value'] = t($default_search_text); // Set a default value for the textfield
    
    // Add extra attributes to the text box
    // Without this a hint autohiding will not work for anonymous.
    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = '$default_search_text';}";
    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == '$default_search_text') {this.value = '';}";
  }
}


function vr_username($object) {
  return str_replace(' ('. t('not verified') .')', '', theme_username($object));
}


/**
* Default theme function for all RSS rows.
*/
function vr_preprocess_views_view_rss(&$vars) {
  $namespaces = $vars['view']->style_plugin->namespaces;
  $disabled_namespaces = array('content', 'dc', 'foaf', 'og', 'rdfs', 'sioc', 'sioct', 'skos', 'xsd', 'xmlns:addthis');
  foreach ($disabled_namespaces as $disabled_namespace) {
    if (isset($namespaces[$disabled_namespace])) {
      unset($namespaces[$disabled_namespace]);
    }
  }
  $vars['namespaces'] = '';
  foreach ($namespaces as $key => $value) {
    $vars['namespaces'] .= ' ' . $key . '="' . $value . '"';
  }
}


/**
* Default theme function for all Archive.
*/
function vr_preprocess_views_view_archive(&$vars) {
  dpr('xxxxzzzz');
  exit;
  //dpm($vars['view']);
}


/**
* Default theme function for all RSS rows.
*/
function vr_preprocess_views_view_row(&$vars) {
  dpm('xxxxxx');
  exit;  
}

/**
* Default theme function for all RSS rows.
*/
function vr_preprocess_views_view_row_rss(&$vars) {
  
  $node = $vars['view']->style_plugin->row_plugin->nodes[$vars['row']->nid];
  //$vars['description'] = check_plain(htmlspecialchars_decode($node->field_a_teaser['und'][0]['value']));
  if (isset($node->body['und'][0]['value'])) {
    $rss_teaser = vr_misc_getArticleTeaserData('all', $node->body['und'][0]['value'], $vars['row']->nid, 400, TRUE);
    // Clear attribute typeof="foaf:Image" from the img tag (which iss added by the core rdf module via hook_preprocess_image).
    $rss_teaser = preg_replace('|typeof="foaf:Image" |', '', $rss_teaser);
    // Convert relative links to absolute.
    $rss_teaser = preg_replace('|href="/|', 'href="http://www.voiprater.com/', $rss_teaser);
    // Restore a normal state of a YouTube url from a token.
    // [video: http://www.youtube.com/watch?v=SoMS77zE7iE]
    $rss_teaser =   preg_replace('|\[video:.*(http.*)\]|', '<a href="$1"> [Watch a video] </a>', $rss_teaser);
    $vars['description'] = check_plain(htmlspecialchars_decode($rss_teaser));
  }
  
  // Replace username with real user name for <dc:creator>
  $vars['item_elements'] = preg_replace('|<dc:creator>.*</dc:creator>|', '<dc:creator>' . vr_misc_getUserRealName($node->uid) . '</dc:creator>', $vars['item_elements']);
}


/**
 * Display the simple view of rows one after another
 */

function vr_preprocess_views_view_unformatted(&$vars) {
//  dpr('yyy');
//exit;
  
  /*
  if( ($vars['view']->name == 'blog' || $vars['view']->name == 'news') && $vars['view']->current_display == 'page') {
    $vars['theme_hook_suggestions'][] = 'views-view-unformatted__blog__page';
    $vars['theme_hook_suggestion'] = 'views-view-unformatted__blog__page';
    dpm($vars);
  }
  */
  
}



/**
 * Theme function for a CAPTCHA element.
 * 
 * a4s rename CAPTCHA to Captcha
 *
 * Render it in a fieldset if a description of the CAPTCHA
 * is available. Render it as is otherwise.
 */
/*
function vr_captcha($variables) {
  $element = $variables['element'];
  if (!empty($element['#description']) && isset($element['captcha_widgets'])) {
    $fieldset = array(
      '#type' => 'fieldset',
      '#title' => t('Captcha'),
      '#description' => $element['#description'],
      '#children' => drupal_render_children($element),
      '#attributes' => array('class' => array('captcha')),
    );
    return theme('fieldset', array('element' => $fieldset));
  }
  else {
    return '<div class="captcha">' . drupal_render_children($element) . '</div>';
  }
}
*/


/**
 * Preprocess the primary theme implementation for a view.
 */

function vr_preprocess_views_view(&$vars) {
  //dpm($vars);
  //$vars['view']->rows = 'xxx';
  //$vars['rows'] = 'xxx';
  
  //$vars['rows'] = 'yyy ' . $vars['view']->render();
  
  if ($vars['view']->current_display == 'block_blog_summary') {
    $out = '';
    foreach ($vars['view']->result as $item) {
      $url = preg_replace('/^(.*)(....)(..)$/', '$1$2/$3', $item->url);
      //$url = str_replace('www.voiprater.com', 'test.www.voiprater.com', $url);
      //$out .= '<li>' . l($item->link, $url) . '</li>';
      $out .= '<li><a href="/' . $url . '">' . $item->link . '</a></li>';
    }
    $out = '<div class="item-list"><ul class="views-summary">' . $out . '</ul></div>';
    $vars['rows'] = $out;
  }

  /*
  // I set title for preface (at vr_misc_views_pre_render(&$view)) instead of a view itself.
//  if ($vars['view']->current_display == 'page_by_tag') {
//    if (!$vars['title']) {
//      $vars['title'] = '<h1>' . $vars['view']->get_title() . '</h1>'; //str_replace('%1', $vars['view']->build_info['substitutions']['%1'], $vars['view']->build_info['title']); 
//    }  
//  }

  // hasn't worked out to make use one temlate for different views unformatted
  
  if (isset($vars['view']->name) && ($vars['view']->name == 'blog' || $vars['view']->name == 'news') ) {
    $function = 'vr_preprocess_views_view_unformatted'; 
    if (function_exists($function)) {
     $function($vars);
    }
  }
*/  
}



/**
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 2. Uncomment the required function to use.
 * 3. Read carefully, especially within vr_preprocess_html(), there
 *    are extra goodies you might want to leverage such as a very simple way of adding
 *    stylesheets for Internet Explorer and a browser detection script to add body classes.
 */
function vr_preprocess_html(&$vars) {
  // Load the media queries styles
  // Remember to rename these files to match the names used here - they are
  // in the CSS directory of your subtheme.
//  $media_queries_css = array(
//    'vr.responsive.style.css',
//    'vr.responsive.gpanels.css'
//  );
//  load_subtheme_media_queries($media_queries_css, 'vr');


//  * Load IE Stylesheets
//  *
//  * AT automates adding IE stylesheets, simply add to the array using
//  * the conditional comment as the key and the stylesheet name as the value.
//  *
//  * See our online help: http://adaptivethemes.com/documentation/working-with-internet-explorer
//  *
//  * For example to add a stylesheet for IE8 only use:
//  *
//  *  'IE 8' => 'ie-8.css',
//  *
//  * Your IE CSS file must be in the /css/ directory in your subtheme.
  
//  Uncomment to add a conditional stylesheet for IE 7 or less.
//  $ie_files = array(
//    'lte IE 7' => 'ie-lte-7.css',
//  );
//  load_subtheme_ie_styles($ie_files, 'vr');

  
  /*
  //dpm($variables);
  //global $user;
  //if ($user->uid == 1) {
    foreach ($variables['page']['content']['system_main']['nodes'] as $key => $html) {
      //dpr($html['body']['#object']->rdf_mapping);
      if (isset($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping['comment_count']['datatype'])) {
        unset($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping['comment_count']['datatype']);
      }
      //dpr($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping);
    }
    //die;
  //}
  */
  
  
  
  // Add class for the active theme name
  // Uncomment to add a class for the active theme name.
  //$vars['classes_array'][] = drupal_html_class($theme_key);
  
  // Works!
  global $user;
  if ($user->uid == 1 || ($user->uid && in_array('administrator', $user->roles)) ) {
    $vars['classes_array'][] = 'admin';
  }
  elseif ($user->uid && in_array('writer', $user->roles) ) {
    $vars['classes_array'][] = 'writer';
  }
  else {
    $vars['classes_array'][] = 'not-admin';
  }
  
  global $body_classes_add;
  if (!empty($body_classes_add)) {
    $vars['classes_array'] += $body_classes_add;
  }

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  //Uncomment to add a classes for the browser and platform.
  //$vars['classes_array'][] = css_browser_selector();

}


/**
 * Process variables for comment.tpl.php.
 *
 * @see comment.tpl.php
 */
function vr_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  /*
  $node = $variables['elements']['#node'];
  $variables['comment']   = $comment;
  $variables['node']      = $node;
  */
  $variables['author']    = $comment->name; //theme('username', array('account' => $comment));
  $variables['created']   = date('m.d.Y \a\t g:ia', $comment->created);//format_date($comment->created);
  $variables['changed']   = date('m.d.Y \a\t g:ia', $comment->changed); //format_date($comment->changed);
/*
  $variables['new']       = !empty($comment->new) ? t('new') : '';
  $variables['picture']   = theme_get_setting('toggle_comment_user_picture') ? theme('user_picture', array('account' => $comment)) : '';
  $variables['signature'] = $comment->signature;

  $uri = entity_uri('comment', $comment);
  $uri['options'] += array('attributes' => array('class' => 'permalink', 'rel' => 'bookmark'));

  $variables['title']     = l($comment->subject, $uri['path'], $uri['options']);
  $variables['permalink'] = l(t('Permalink'), $uri['path'], $uri['options']);
  $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['author'], '!datetime' => $variables['created']));

  // Preprocess fields.
  field_attach_preprocess('comment', $comment, $variables['elements'], $variables);

  // Helpful $content variable for templates.
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Set status to a string representation of comment->status.
  if (isset($comment->in_preview)) {
    $variables['status'] = 'comment-preview';
  }
  else {
    $variables['status'] = ($comment->status == COMMENT_NOT_PUBLISHED) ? 'comment-unpublished' : 'comment-published';
  }

  // Gather comment classes.
  // 'comment-published' class is not needed, it is either 'comment-preview' or
  // 'comment-unpublished'.
  if ($variables['status'] != 'comment-published') {
    $variables['classes_array'][] = $variables['status'];
  }
  if ($variables['new']) {
    $variables['classes_array'][] = 'comment-new';
  }
  if (!$comment->uid) {
    $variables['classes_array'][] = 'comment-by-anonymous';
  }
  else {
    if ($comment->uid == $variables['node']->uid) {
      $variables['classes_array'][] = 'comment-by-node-author';
    }
    if ($comment->uid == $variables['user']->uid) {
      $variables['classes_array'][] = 'comment-by-viewer';
    }
  }
 */
}

