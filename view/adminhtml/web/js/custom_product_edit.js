require([
    'jquery'
], function ($) {
    'use strict';
    jQuery(document).ready(function(){
        //Custom js here
        var intervalId = setInterval(function() {
            var element = jQuery(document).find("div").find("[data-index='container_category_ids']");
            if(element.length > 0) {
                var el = jQuery(element).find(".admin__field.admin__field-group-additional.admin__field-small").append("<button class='action-basic clear-categories' type='button' style='margin-top:15px;'>Clear Categories</button>");
                clearInterval(intervalId);
                jQuery(".clear-categories").on("click", function() {
                    jQuery(document).find("div").find("[data-index='container_category_ids']").find(".action-select").find(".admin__action-multiselect-crumb").find(".action-close").trigger("click");
                });
            }
        }, 1000);
    });
});
