;(function Drawer($){
  'use strict';
  // var namespace = 'drawer';
  // var touches = typeof document.ontouchstart != 'undefined';
  var __ = {
    init: function init( options ){

      options = $.extend({
        iscroll: {
          mouseWheel: true,
          preventDefault: false
        },
        showOverlay: true
      }, options);

      __.settings = {
        state: false,
        events: {
          opened: 'drawer.opened',
          closed: 'drawer.closed'
        },
        dropdownEvents: {
          opened: 'shown.bs.dropdown',
          closed: 'hidden.bs.dropdown'
        }
      };

      __.settings.class = $.extend({
        nav: 'drawer-nav',
        toggle: 'drawer-toggle',
        overlay: 'drawer-overlay',
        open: 'drawer-open',
        close: 'drawer-close',
        dropdown: 'drawer-dropdown'
      }, options.class);


      return this.each(function instantiateDrawer() {
        console.log('jQuery plugin');
        window.document.getElementById('element').innerHTML = "jQuery plugin";
        $('#element').css("background-color", "blue");
        // window.document.getElementById('element').style."background-color"="blue";

      });
    },

    refresh: function refresh(){
      console.log('refresh');
      window.document.getElementById('element').innerHTML = "refresh";
    },

    addOverlay: function addOverlay(){
      console.log('addOverlay');
      window.document.getElementById('element').innerHTML = "addOverlay";
    },

    toggle: function toggle(){
      console.log('toggle');
      window.document.getElementById('element').innerHTML = "toggle";
    },

    open: function open(){
      console.log('open');
      window.document.getElementById('element').innerHTML = "open";
    },

    close: function close(){
      console.log('close');
      window.document.getElementById('element').innerHTML = "close";
    },

    destroy: function close(){
      console.log('close');
      window.document.getElementById('element').innerHTML = "destroy";
    }
  }

  $.fn.drawer = function( method ) {
    if( __[method] ){
        return __[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
      } else if ( typeof method === 'object' || ! method ) {
        return methods.init.apply( this, arguments );
      } else {
        $.error( 'Method ' +  method + ' does not exist on jQuery.drawer' );
      }
  };
})( jQuery );
