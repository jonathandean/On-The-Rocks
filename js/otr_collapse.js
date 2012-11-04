var OTR = OTR || {};
OTR.Collapse = function(options) {
  // default options
  function defaultOpts() {}
  defaultOpts.prototype = {
    article_selector: 'article',
    collapsed_article_class: 'collapse',
    collapse_link_class: 'otr_show_collapsed'
  }
  // private vars
  var self = this,
    opts = $.extend({}, new defaultOpts(), options);
  // private methods
  function otr_show_collapsed(e){
    e.preventDefault();
    $(this).parent().hide().nextUntil(opts.article_selector+':not(.'+opts.collapsed_article_class+')').show();
  }
  function otr_collapse(items){
    if(items.length < 1){ return; }
    $('<p class="'+opts.collapse_link_class+'"><a href="#" class="'+opts.collapse_link_class+'">Show '+items.length+' hidden '+(items.length > 1 ? otr_cts_label_pl : otr_cts_label)+'</a></p>').insertBefore(items[0]);
    $.each(items, function(i,v){
      items[i].hide();
    });
  }
  function init() {
    $('a.'+opts.collapse_link_class).live('click', otr_show_collapsed);
  }
  init();
  
  // public methods
  self.setup = function(){
    var currentSet = [];
    $(opts.article_selector).each(function(i){
      var $this = $(this);
      if($this.hasClass(opts.collapsed_article_class)){
        currentSet.push($this);
      }else if(currentSet.length > 0){
        otr_collapse(currentSet);
        currentSet = [];
      }
    });
    otr_collapse(currentSet);
  }
};

var otr_c = new OTR.Collapse();
$(function(){
  otr_c.setup();
});