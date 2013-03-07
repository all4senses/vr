(function ($) {

  Drupal.behaviors.vr_SendMsgNnewsletterSubscr_fieldHints = {
    attach: function (context, settings) {
      
      //$('#block-vr_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-email"], #block-vr_blocks-send_msg_n_subscribe textarea[id="edit-message"]').each(function(){
      $('#block-vr-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-email"], #block-vr-blocks-send-msg-n-subscribe textarea[id="edit-message"]').each(function(){
        if ($(this).val() == '') {
          $(this).val($(this).attr('title'));
          $(this).addClass('blur');
        }
        else if ($(this).val() == $(this).attr('title')) {
          $(this).addClass('blur');
        }
      });
      
      //$('#block-vr_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-email"], #block-vr_blocks-send_msg_n_subscribe textarea[id="edit-message"]').focus(function(){
      $('#block-vr-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-email"], #block-vr-blocks-send-msg-n-subscribe textarea[id="edit-message"]').focus(function(){        
        if ($(this).val() == $(this).attr('title')) {
          $(this).val('');
          $(this).removeClass('blur');
        }
        
      });
      
      //$('#block-vr_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-vr_blocks-send_msg_n_subscribe input[id="edit-email"], #block-vr_blocks-send_msg_n_subscribe textarea[id="edit-message"]').blur(function(){
      $('#block-vr-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-vr-blocks-send-msg-n-subscribe input[id="edit-email"], #block-vr-blocks-send-msg-n-subscribe textarea[id="edit-message"]').blur(function(){
        
        if ($(this).val() == '') {
          $(this).val($(this).attr('title'));
          $(this).addClass('blur');
        }
        
      });
      
    }
  };

}(jQuery));