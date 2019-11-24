(function($){

  // Get the path to the current directory.
  var jsDirectory = SiteData.url + '/js';

  $(document).ready(function(){

    // Custom Javascript goes here. 

    // Reverse the first two category dropdown selections, and
    // load the correct page when a category is selected.
    /*
        var dropdown = $('#cat');
        dropdown.prepend(dropdown.children().eq(1));
        $('#cat').change( function() {
        if ( this.options[this.selectedIndex].value >= 0 ) {
            var pathArray = location.pathname.split( '/' );
            var page = '';
                for(var i = 0; i<pathArray.length; i++) {
                    if (pathArray[i]) {
                        page = pathArray[i];
                        break;
                    }
                }
            location.href =  [ location.protocol, '//', location.host, '/', page,
                "/?cat=", this.options[this.selectedIndex].value ].join('');
        }
        });
        */

    // Load the page corresponding to the chosen blog category.
    $('.cat-item a').click(function(e) {
      e.preventDefault();
      var pathArray = $(this).attr('href').split( '/' );
      pathArray = $.grep(pathArray, function(n) { return(n) });
      location.href =  [ location.protocol, '//', location.host, '/blog/?cat=',
        pathArray[pathArray.length-1] ].join('');

    });

    // Home page slider.
    $('#home-books').flexslider({
      slideshow: false,
      animation: "slide",
      animationLoop: true,
      itemWidth: 208,
      itemMargin: 12,
      initDelay: 2000,
    });

    // Don't show images until after they load.
    $('.fade-in-opacity').animate({opacity:1}, 1000);
    $('.fade-in-display').fadeIn(1500);

    // Append hidden text to the page, then copy it to the clipbaord.
    window.copyToClipboard = function(str) {
      var $temp = $('<input>');
      $('body').append($temp);
      $temp.val(str).select();
      document.execCommand('copy');
      $temp.remove();
    }
  });

})(jQuery);
