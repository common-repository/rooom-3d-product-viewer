
(function ($) {
    $('#submit').remove();


    //extract values from shortcode generator tab, create shortcode and put it back out to be copied
    $('#shortcode-generator-submit').click(function(){
        $('#shortcode-product-viewer-key').removeClass("empty");
        $('.no-key').addClass("hidden");
        var viewerKey = $('#shortcode-product-viewer-key').val();

        if ("" == viewerKey){
            $('#shortcode-product-viewer-key').addClass("empty");
            $('.no-key').removeClass("hidden");
            return
        }
        var height = $('#shortcode-iframe-height').val();
        height = parseInt(height);
        
        
        var newShortcode = '[rooom-3D-product-viewer viewer_key=' + viewerKey;
        if ('' != height && !isNaN(height)){
            
            newShortcode += ' height=' + height;
        }
        newShortcode += ']';
        console.log(newShortcode);

        $('#iframe-shortcode').removeAttr("disabled");
        $('#iframe-shortcode').val(newShortcode);

    })
  })(jQuery);