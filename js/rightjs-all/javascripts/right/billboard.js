/**
 * RightJS-UI Billboard v2.2.0
 * http://rightjs.org/ui/billboard
 *
 * Copyright (C) 2010-2011 Nikolay Nemshilov
 */
var Billboard=RightJS.Billboard=function(a){function b(b,c){c||(c=b,b="DIV");var d=new a.Class(a.Element.Wrappers[b]||a.Element,{initialize:function(c,d){this.key=c;var e=[{"class":"rui-"+c}];this instanceof a.Input||this instanceof a.Form||e.unshift(b),this.$super.apply(this,e),a.isString(d)&&(d=a.$(d)),d instanceof a.Element&&(this._=d._,"$listeners"in d&&(d.$listeners=d.$listeners),d={}),this.setOptions(d,this);return a.Wrapper.Cache[a.$uid(this._)]=this},setOptions:function(b,c){c&&(b=a.Object.merge(b,(new Function("return "+(c.get("data-"+this.key)||"{}")))())),b&&a.Options.setOptions.call(this,a.Object.merge(this.options,b));return this}}),e=new a.Class(d,c);a.Observer.createShortcuts(e.prototype,e.EVENTS||a([]));return e}var c=a,d=a.$,e=a.$$,f=a.$w,g=a.$E,h=a.Fx,i=a.Class,j=a.Object,k=new b("UL",{extend:{version:"2.2.0",EVENTS:f("change first last"),Options:{fxName:"stripe",fxDuration:"long",autostart:!0,delay:4e3,loop:!0,showButtons:!0,prevButton:"native",nextButton:"native",stripes:10,cssRule:"*.rui-billboard"}},initialize:function(a){this.$super("billboard",a),this.options.showButtons&&(this.prevButton=this.options.prevButton!=="native"?d(this.options.prevButton):g("div",{"class":"rui-billboard-button-prev",html:"&lsaquo;"}).insertTo(this),this.nextButton=this.options.nextButton!=="native"?d(this.options.nextButton):g("div",{"class":"rui-billboard-button-next",html:"&rsaquo;"}).insertTo(this),this.prevButton.onClick(c(function(a){a.stop(),this.showPrev()}).bind(this)),this.nextButton.onClick(c(function(a){a.stop(),this.showNext()}).bind(this))),this.onChange(function(a){a.item===this.items().first()?this.fire("first"):a.item===this.items().last()&&this.fire("last")}),this.on({mouseover:function(){this.stop()},mouseout:function(a){this.options.autostart&&!a.find(".rui-billboard")&&this.start()}}),this.options.autostart&&this.start()},items:function(){return this.children().without(this.prevButton,this.nextButton)},showNext:function(){var a=this.items(),b=a.indexOf(this.current())+1;b==a.length&&this.options.loop&&(b=0);return this.current(b)},showPrev:function(){var a=this.items(),b=a.indexOf(this.current())-1;b<0&&this.options.loop&&(b=a.length-1);return this.current(b)},current:function(a){var b=this.items();if(arguments.length)a instanceof Element&&(a=b.indexOf(a)),this.runFx(b[a]);else return b.length?b.first("hasClass","rui-billboard-current")||b.first().addClass("rui-billboard-current"):null;return this},start:function(){this.timer=c(this.showNext).bind(this).periodical(this.options.delay)},stop:function(){this.timer&&this.timer.stop()},fire:function(a,b){return this.$super(a,j.merge({index:this.items().indexOf(this.current()),item:this.current()},b))},runFx:function(a){if(a&&!this._running){var b=k.Fx[c(this.options.fxName||"").capitalize()];b?(new b(this)).start(this.current(),a):(this.current().removeClass("rui-billboard-current"),a.addClass("rui-billboard-current"))}}});k.Fx=new i(h,{initialize:function(a){this.container=g("div",{"class":"rui-billboard-fx-container"}),this.$super(a,{duration:a.options.fxDuration,onStart:function(){a._running=!0,a.insert(this.container)},onFinish:function(){this.container.remove(),a._running=!1,a.fire("change")}})},prepare:function(a,b){a.removeClass("rui-billboard-current"),b.addClass("rui-billboard-current"),this.clone=a.clone(),this.container.update(this.clone)}}),k.Fx.Fade=new i(k.Fx,{prepare:function(a,b){this.$super(a,b)},render:function(a){this.container.setStyle({opacity:1-a})}}),k.Fx.Slide=new i(k.Fx,{prepare:function(a,b){this._width=this.element.current().size().x,this._direction=a.nextSiblings().include(b)?-1:1,this.$super(a,b),this.clone.setStyle({width:this._width+"px"})},render:function(a){this.clone._.style.left=this._direction*this._width*a+"px"}}),k.Fx.Stripe=new i(k.Fx,{directions:["down","up","left","right"],prepare:function(a,b){this.$super(a,b);var d=this.element.options.stripes,e=this.element.items()[0].size().x/d,f=100,h=this.directions.shift();this.directions.push(h),this.container.clean();for(var i=0;i<d;i++){var j=g("div",{"class":"rui-billboard-stripe",style:{width:e+1+"px",left:i*e+"px"}}).insert(a.clone().setStyle({width:e*d+"px",left:-i*e+"px"}));this.container.append(j);var k={duration:this.options.duration};if(h!=="right"&&i===d-1||h==="right"&&i===0)k.onFinish=c(this.finish).bind(this,!0);switch(h){case"up":c(function(a,b){a.setHeight(a.size().y),a.morph({height:"0px"},b)}).bind(this,j,k).delay(i*f);break;case"down":j.setStyle("top: auto; bottom: 0px"),c(function(a,b){a.setHeight(a.size().y),a.morph({height:"0px"},b)}).bind(this,j,k).delay(i*f);break;case"left":c(function(a,b){a.morph({width:"0px"},b)}).bind(this,j,k).delay(i*f);break;case"right":c(function(a,b){a.morph({width:"0px"},b)}).bind(this,j,k).delay((d-i-1)*f);break;default:this.finish(!0)}}},finish:function(a){a&&this.$super();return this}}),d(document).onReady(function(){e(k.Options.cssRule).each(function(a){a instanceof k||(a=new k(a))})});var l=document.createElement("style"),m=document.createTextNode("*.rui-billboard, *.rui-billboard> *{margin:0;padding:0;list-style:none} *.rui-billboard{display:inline-block; *display:inline; *zoom:1;position:relative} *.rui-billboard> *{display:none;width:100%;height:100%} *.rui-billboard> *:first-child, *.rui-billboard> *.rui-billboard-current:first-child{display:block;position:relative} *.rui-billboard> *>img{margin:0;padding:0} *.rui-billboard-current{position:absolute;left:0;top:0;display:block;z-index:999} *.rui-billboard-button-prev, *.rui-billboard-button-next{position:absolute;z-index:99999;left:.25em;top:auto;bottom:.25em;display:block;width:.5em;height:auto;text-align:center;font-size:200%;font-family:Arial;font-weight:bold;padding:0em .5em .2em .5em;background:white;opacity:0;filter:alpha(opacity:0);cursor:pointer;border:.12em solid #888;border-radius:.2em;-moz-border-radius:.2em;-webkit-border-radius:.2em;user-select:none;-moz-user-select:none;-webkit-user-select:none;transition:opacity .3s ease-in-out;-o-transition:opacity .3s ease-in-out;-moz-transition:opacity .3s ease-in-out;-webkit-transition:opacity .3s ease-in-out} *.rui-billboard-button-next{left:auto;right:.25em;text-align:right} *.rui-billboard-button-prev:active{text-indent:-.1em} *.rui-billboard-button-next:active{text-indent:.2em} *.rui-billboard:hover *.rui-billboard-button-prev, *.rui-billboard:hover *.rui-billboard-button-next{opacity:0.4;filter:alpha(opacity:40)} *.rui-billboard:hover *.rui-billboard-button-prev:hover, *.rui-billboard:hover *.rui-billboard-button-next:hover{opacity:0.7;filter:alpha(opacity:70)}.rui-billboard-fx-container{position:absolute;left:0;top:0;display:block;z-index:9999;overflow:hidden}.rui-billboard-fx-container> *{position:absolute;left:0;top:0}.rui-billboard-stripe{overflow:hidden}.rui-billboard-stripe> *{position:relative}");l.type="text/css",document.getElementsByTagName("head")[0].appendChild(l),l.styleSheet?l.styleSheet.cssText=m.nodeValue:l.appendChild(m);return k}(RightJS)