(function ($) {

  Drupal.behaviors.vr_homeContentRotator = {
    attach: function (context, settings) {
       
       $("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
       
       console.log('teeest');
       
    }
  };

}(jQuery));
