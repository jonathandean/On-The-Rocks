(function($){
  // TODO make indentation a setting
  $('article.post .content > p:first, h1 ~ p:first, h2 ~ p:first, h3 ~ p:first, h4 ~ p:first, h5 ~ p:first, h6 ~ p:first').addClass('first');
})(jQuery);