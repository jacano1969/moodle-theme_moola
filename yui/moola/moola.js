YUI.add('moodle-theme_moola-moola', function(Y) {
    
var moola = function() {
    moola.superclass.constructor.apply(this, arguments);
}
moola.prototype = {
   initializer : function() {
       this.initialiseFaceSwitcher();
   },
   initialiseFaceSwitcher : function() {
       Y.all('.fake_block_moola').each(function(node){
           node.all('.possibleface').on('click', this.switchFace, this);
           node.removeClass('hidden');
       }, this);
   },
   switchFace : function(e) {
       Y.one(document.body).removeClass(this.get('currentface'));
       Y.one(document.body).addClass('moola_face_'+e.target.getAttribute('rel'));
       this.set('currentface', 'moola_face_'+e.target.getAttribute('rel'));
   }
}
Y.extend(moola, Y.Base, moola.prototype, {
    NAME : 'moola',
    ATTRS : {
        currentface : {}
    }
});

M.theme = M.theme || {};
M.theme.moola = M.theme.moola || {};
M.theme.moola.instance = null;
M.theme.moola.init = function(config) {
    M.theme.moola.instance = new moola(config);
}
    
}, '@VERSION@', {requires:['base','node','event']});
