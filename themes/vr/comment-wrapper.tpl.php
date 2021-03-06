<section id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  
    <?php if ($content['comment_form']): ?>
    <section id="comment-form-wrapper">
      <h2 class="title"><?php print t('Add your comment'); ?></h2>
      
      <?php
      $content['comment_form']['actions']['submit']['#value'] = t('Submit');
      ?>
      
      <?php print render($content['comment_form']); ?>
    </section> <!-- /#comment-form-wrapper -->
  <?php endif; ?>

    
  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h2 class="title"><?php print 'Responses to "' . $node->title . '"'; ?></h2>
    <?php print render($title_suffix); ?>
  <?php endif; ?>
    
  <?php print render($content['comments']); ?>
  
</section> <!-- /#comments -->
