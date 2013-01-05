// From https://github.com/jonathandean/svg_fallback
(function(global){
  var svg = !!('createElementNS' in document && document.createElementNS('http://www.w3.org/2000/svg','svg').createSVGRect);
  if (!svg){
    document.body.className += ' no-svg';
    (global.svgFallback = function(){
      var i, elements = document.getElementsByTagName('img');
      for (i=0;i<elements.length;i++){
        var fp = elements[i].getAttribute('src').split(".");
        var ext = fp.pop();
        if(ext.toLowerCase() == 'svg'){
          var attr = elements[i].getAttribute('data-svg-fallback');
          if (attr !== null) {
            elements[i].src = attr;
            elements[i].removeAttribute('data-svg-fallback');
          }else{
            elements[i].src = fp.join('.')+'.png';
          }
        }
      }
    })()
  }else{ document.body.className += ' svg'; }
})(this);