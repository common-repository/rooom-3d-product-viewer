(function ($) {
  $(function () {

    let addAttribute = function(checkbox, el) {
      checkbox.is(":checked") ? el.attr('required', 'required') : el.removeAttr('required');
    }

    /* Add Color Picker to all inputs that have 'color-field' class */
    $('.cpa-color-picker').wpColorPicker();

    let checkBox = $('#_rooom_viewer_enabled');
    let viewerID = $('#_rooom_viewer_product_id');

    addAttribute(checkBox, viewerID);

    checkBox.change(function () {
      addAttribute(checkBox, viewerID);
    });

  });
})(jQuery);
