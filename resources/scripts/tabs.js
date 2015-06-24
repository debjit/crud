/**
 * Created by mgalicz on 2015.06.24..
 */

(function ($, window, document, undefined) {

    'use strict';

    // auto tab selection
    $('.nav-tabs a:first').tab('show');
    $(document).on('loaded.bs.modal', function () {
        $('.nav-tabs a:first').tab('show');
    });

})(jQuery, window, document);