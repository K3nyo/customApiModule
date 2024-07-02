/**
 * ALA color field.
 **/

(function ($, window, Drupal) {
    Drupal.behaviors.alaColorField = {
        attach: function attach(context)
        {

            $(".alaColorField", context).each(
                function () {
                    if (!$(this).next().is('.alaTmpColor')) {
                        $('<input type="color" class="alaTmpColor" value="'+$(this).val()+'">').insertAfter($(this))
                    }
                }
            );

        }
    };
    $(document).on(
        "change", '.alaTmpColor', function () {
            $(this).prev().val($(this).val());
        }
    );

})(jQuery, window, Drupal);
