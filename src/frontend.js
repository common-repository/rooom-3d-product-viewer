(function ($) {
  $(function () {

    var $div = $(".rooom_product_viewer");

    if ($div.length > 0){
      
      var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.attributeName === "class") {
            var attributeValue = $(mutation.target).prop(mutation.attributeName);
            
            if(attributeValue.indexOf('flex-active-slide') > -1){
              $('.woocommerce-product-gallery__trigger').hide()
            } else {
              $('.woocommerce-product-gallery__trigger').show()
            }

          }
        });
      });
      
        observer.observe($div[0], {
          attributes: true
        });

      var urlThumb = $div.data('thumb_bg');
      var thumb_list = $('.flex-control-nav.flex-control-thumbs li');

      for (list of thumb_list){
        if (list.firstChild.alt == 'Rooom Product Viewer'){
          list.setAttribute("style", 'background-image: url('+ urlThumb +');background-position: center;background-size: cover;')
        }
      }
    }
  });
})(jQuery);