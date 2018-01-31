/**
 * Created by Maarten on 31/01/2018.
 */
(function($){
    $('figure.wp-caption.aligncenter').removeAttr('style');
    $('img.aligncenter').wrap('<figure class="centered-image" />');
})(jQuery);

