/*
 * jQuery COnePage; v20131130
 * https://compojoom.com
 * Copyright (c) 2013 Yves Hoppe; License: GPL v2 or later
 */

(function( $ ) {

    var version = "20131130";
    var debug = 1;

    $.fn.copnavi = function( options ) {

        var settings = $.extend({
            // Default settings - see API instructions
            class: ".section",
            modid: 0,
            imgpath: 'media/mod_conepage_navi/images/'
        }, options );

        var holder = $.extend({
            log: $.fn.copnavi.log,
            container: null,
            sections: null,
            count: 0,
            current: 0
        });

        var API = $.extend({

            init: function() {
                holder.sections = $(settings.class);

                holder.sections.each(function(){
                    // Single section item
                    var sect = $( this );

                    var stitle = this.getAttribute("data-section-title");
                    var sicon = this.getAttribute("data-section-icon");
                    var sid = this.getAttribute("id");

                    holder.container.append('<li class="cop_navi_element">'
                        + '<a id="scroll_' + sid + '" href="#' + sid + '" title="' + stitle + '" class="cop_navi_link '
                        + 'hasTooltip" data-placement="right" title="' + stitle + '">'
                        + '<img src="' + settings.imgpath + sicon + '" alt="' + stitle + '" />'
                        + '</a>'
                        + '</li>'
                    );

                    $('#scroll_' + sid).click(function(){
                        $('html, body').animate({
                            scrollTop: $("#" + sid).offset().top
                        }, 800);
                        return false;
                    });
                });

                holder.sections.first().css("border", "0");
                return true;
            }
        });

        return this.each(function(){
            holder.log('-- COnePage Navi Init --');
            holder.container = $(this);

            var success = API.init();
            holder.log('-- Init Status:  '  + success + ' --');

            $('body').scrollspy({ target: '.conepage_navi_holder' })
        });
    }

    // Logging to console
    $.fn.copnavi.log = function log() {
        if (window.console && console.log && debug == 1 )
            console.log('[copnavi] ' + Array.prototype.join.call(arguments, ' ') );
    }

    $.fn.copnavi.greyscale = function grayscale(image){
        if (supportsCanvas) {
            $(image).jaload(function(){
                var canvas = document.createElement('canvas'),
                    context = canvas.getContext('2d'),
                    imageData, px, length, i = 0, gray;

                canvas.width = image.naturalWidth ? image.naturalWidth : image.width;
                canvas.height = image.naturalHeight ? image.naturalHeight : image.height;

                context.drawImage(image, 0, 0);

                imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                px = imageData.data;
                length = px.length;

                for (; i < length; i += 4) {
                    px[i] = px[i + 1] = px[i + 2] = (px[i] + px[i + 1] + px[i + 2]) /3;
                }

                context.putImageData(imageData, 0, 0);
                image.src = canvas.toDataURL();

                $(image).css('opacity', 0).animate({opacity: 1}, 500);
            });
        }
    }

}( jQuery ));