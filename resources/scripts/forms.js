/**
 * Created by mgalicz on 2015.06.24..
 */

(function ($, window, document, undefined) {

    'use strict';

    /* Ajax form submit */
    $(document).on('submit', 'form[data-async]', function (e) {
        var $form   = $(this),
            $target = $($form.attr('data-target'));

        $.ajax({
            type: $form.attr('method'),
            url:  $form.attr('action'),
            data: $form.serialize(),
            success: function (data) {
                $target.html(data);
            }
        });

        e.preventDefault();
    });

    /* Infinite fields */
    $(document)
        .on('click', '.field-infinite a[data-event="field-add"]', function () {
            var clone = $(this).closest('[data-multiply]').clone();

            $(clone).find('input').val('');
            $(clone).find('.image-preview').css('background-image', '');
            $(this).closest('[data-multiply]').after(clone);

            redrawInfiniteFieldButtons();
        }).on('click', '.field-infinite a[data-event="field-remove"]', function () {
            $(this).closest('[data-multiply]').remove();

            redrawInfiniteFieldButtons();
        });

    function redrawInfiniteFieldButtons () {
        $('.form-group').each(function () {
            var addFields    = $(this).find('[data-event="field-add"]'),
                removeFields = $(this).find('[data-event="field-remove"]');

            for (var i = 0; i < addFields.length -1; i++) {
                addFields.eq(i).hide();
                removeFields.eq(i).show();
            }

            // multiple limit
            var limit = $(this).find('input').last().attr('multiple-limit');
            if (limit != undefined) {
                var fields = $(this).find('input').length;

                if (fields >= limit) {
                    addFields.last().hide();
                } else {
                    addFields.last().show();
                }
            }
        });
    }

})(jQuery, window, document);