/**
 * raphael.pan-zoom plugin 0.2.1
 * Copyright (c) 2012 @author Juan S. Escobar
 * https://github.com/escobar5
 *
 * licensed under the MIT license
 */
 
(function () {
    'use strict';
    /*jslint browser: true*/
    /*global Raphael*/
    
    function findPos(obj) {
        var posX = obj.offsetLeft, posY = obj.offsetTop, posArray;
        while (obj.offsetParent) {
            if (obj === document.getElementsByTagName('body')[0]) {
                break;
            } else {
                posX = posX + obj.offsetParent.offsetLeft;
                posY = posY + obj.offsetParent.offsetTop;
                obj = obj.offsetParent;
            }
        }
        posArray = [posX, posY];
        return posArray;
    }
    
    function getRelativePosition(e, obj) {
        var x, y, pos;
        if (e.pageX || e.pageY) {
            x = e.pageX;
            y = e.pageY;
        } else {
            x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }

        pos = findPos(obj);
        x -= pos[0];
        y -= pos[1];

        return { x: x, y: y };
    }

    var panZoomFunctions = {
        enable: function () {
            this.enabled = true;
        },

        disable: function () {
            this.enabled = false;
        },

        zoomIn: function (steps) {
            this.applyZoom(steps);
        },
        zoomIn2: function (steps,centerpoint) {
            this.applyZoom(steps,centerpoint);
        },
        zoomOut: function (steps) {
            this.applyZoom(steps > 0 ? steps * -1 : steps);
        },

        pan: function (deltaX, deltaY) {
            this.applyPan(deltaX * -1, deltaY * -1);
        },

        isDragging: function () {
            return this.dragTime > this.dragThreshold;
        },

        getCurrentPosition: function () {
            return this.currPos;
        },

        getCurrentZoom: function () {
            return this.currZoom;
        }
    },

        PanZoom = function (el, options) {
            var paper = el,
                container = paper.canvas.parentNode,
                me = this,
                settings = {},
                initialPos = { x: 0, y: 0 },
                deltaX = 0,
                deltaY = 0, panLevel = 0, jarakX = 0, jarakY = 0,
                mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";

            this.enabled = false;
            this.dragThreshold = 5;
            this.dragTime = 0;
    
            options = options || {};
    
            settings.maxZoom = options.maxZoom || 9;
            settings.minZoom = options.minZoom || 0;
            settings.zoomStep = options.zoomStep || 0.1;
            settings.initialZoom = options.initialZoom || 0;
            settings.initialPosition = options.initialPosition || { x: 0, y: 0 };
            settings.zoomStepLeap = 0.1;
            this.currZoom = settings.initialZoom;
            this.currPos = settings.initialPosition;
            
            function zoomcenterleap(e,c) {
               // return false; //roy
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep)),
                    newPoint = getRelativePosition(evt, container);
                   // alert(evt.button); //roy
                   
               //console.log('with '+newWidth+' '+newHeight);
               
               
               var tengahX = newWidth/2;
               var tengahY = newHeight/2;
               
               //console.log('tengah '+tengahX+' '+tengahY);
               
               var newx,newy;
               var posnewx,posnewy;
               
               var bb = c.getBBox();
               //console.log('cxy '+bb.cx+' '+bb.cy);
               
                
               newx = ((tengahX-bb.cx)*(-1))-me.currPos.x;
               newy = ((tengahY-bb.cy)*(-1))-me.currPos.y;  
               
                posnewx = bb.cx-me.currPos.x;
                posnewy = bb.cy-me.currPos.y;
                     
                //console.log('delta '+posnewx+' '+posnewy);
                //cari posisi point of view nya
                deltaX = newx;
                deltaY = newy;
                
                return {x:posnewx,y:posnewy};
            }
            this.zoomcenterleap = zoomcenterleap;
            
            function resetPanLvl() {
                panLevel = 0;
            }
            this.resetPanLvl = resetPanLvl;
           
            function panTo(e,c) {
               // return false; //roy
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep)),
                    newPoint = getRelativePosition(evt, container);
                   // alert(evt.button); //roy
                   
               //console.log('with '+newWidth+' '+newHeight);
               
               
               var tengahX = newWidth/2;
               var tengahY = newHeight/2;
               
               //console.log('tengah '+tengahX+' '+tengahY);
               
               var newx,newy;
               
               var bb = c.getBBox();
               //console.log('cxy '+bb.cx+' '+bb.cy);
               
                
               newx = ((tengahX-bb.cx)*(-1))-me.currPos.x;
               newy = ((tengahY-bb.cy)*(-1))-me.currPos.y;  
                     
                     
                //console.log('delta '+newx+' '+newy);
                //cari posisi point of view nya
                deltaX = newx;
                deltaY = newy;
                
                repaint_leap();
            }
            this.panTo = panTo;
            
            function fixTujuan(e,c) {                
               // return false; //roy
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep)),
                    newPoint = getRelativePosition(evt, container);
                   // alert(evt.button); //roy
                   
               //('with '+newWidth+' '+newHeight);
               
               
              var tengahX = newWidth/2;
               var tengahY = newHeight/2;
               
              // //console.log('tengah '+tengahX+' '+tengahY);
               
               var newx,newy;
               
               var bb = c.getBBox();
               ////console.log('cxy '+bb.cx+' '+bb.cy);
               
                
               newx = ((tengahX-bb.cx)*(-1))-me.currPos.x;
               newy = ((tengahY-bb.cy)*(-1))-me.currPos.y;                      
               jarakX = (newx)*0.1;
               jarakY = (newy)*0.1;
               return 1;
            }
            this.fixTujuan = fixTujuan;
            
            function slowpanTo(e,c) {                
               // return false; //roy
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep)),
                    newPoint = getRelativePosition(evt, container);
                   // alert(evt.button); //roy
                   
               //('with '+newWidth+' '+newHeight);
               
               
           //   var tengahX = newWidth/2;
            //   var tengahY = newHeight/2;
               
              // //console.log('tengah '+tengahX+' '+tengahY);
               
             //  var newx,newy;
               
              // var bb = c.getBBox();
               ////console.log('cxy '+bb.cx+' '+bb.cy);
               
                
             //  newx = ((tengahX-bb.cx)*(-1))-me.currPos.x;
             //  newy = ((tengahY-bb.cy)*(-1))-me.currPos.y;  
                     
               //var pitagoras =   Math.sqrt(((newx*newx) - (me.currPos.x*me.currPos.x))+((newy*newy)-(me.currPos.y*me.currPos.y)));
                ////console.log('delta '+newx+' '+newy);
                
                if(me.currPos.x == (jarakX*10) && me.currPos.y == (jarakY*10) )return 1;
                //cari posisi point of view nya
                if(panLevel == 10)return 1;
               // if(me.currPos.x == newx && me.currPos.y ==newy )return 1;
                deltaX = jarakX;
                deltaY = jarakY;
                panLevel++;
                
                ////console.log(panLevel+' curr x '+me.currPos.x+' y '+me.currPos.y+' tujuan '+newx+' '+newy+' step e '+deltaX+' '+deltaY);
                
                repaint_leap();
                return 0;
            }
            this.slowpanTo = slowpanTo;
            
            function applyZoom_leap(val, centerPoint) {
                if (!me.enabled) {
                    return false;
                }
                //if (me.currZoom < settings.maxZoom)val = 1;
                me.currZoom += val;
                if (me.currZoom < 10) {
                    me.currZoom = 10;
                   if(val == -1) return 0;
                   else{
                        centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
                    ////console.log('paper w h '+paper.width+' '+paper.height);
                    deltaX = ((paper.width * settings.zoomStepLeap) * (centerPoint.x / paper.width)) * val;
                    deltaY = (paper.height * settings.zoomStepLeap) * (centerPoint.y / paper.height) * val;
    
                   repaint_leap();
                   return 1;
                   }
                } else if (me.currZoom > settings.maxZoom) {
                    me.currZoom = settings.maxZoom;
                    return 0;
                } else {
                    centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
                    ////console.log('paper w h '+paper.width+' '+paper.height);
                    deltaX = ((paper.width * settings.zoomStepLeap) * (centerPoint.x / paper.width)) * val;
                    deltaY = (paper.height * settings.zoomStepLeap) * (centerPoint.y / paper.height) * val;
    
                   repaint_leap();
                   return 1;
                }
            }
    
            this.applyZoom_leap = applyZoom_leap;
            
                function applyZoom_leap2(val, centerPoint) {
                if (!me.enabled) {
                    return false;
                }
                //if (me.currZoom < settings.maxZoom)val = 1;
                me.currZoom += val;
                if (me.currZoom < 15) {
                    me.currZoom = 15;
                    return 0;
                } else if (me.currZoom > settings.maxZoom) {
                    me.currZoom = settings.maxZoom;
                    return 0;
                } else {
                    centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
                    //console.log('paper w h '+paper.width+' '+paper.height);
                    deltaX = ((paper.width * settings.zoomStepLeap) * (centerPoint.x / paper.width)) * val;
                    deltaY = (paper.height * settings.zoomStepLeap) * (centerPoint.y / paper.height) * val;
    
                   repaint_leap();
                   return 1;
                }
            }
    
            this.applyZoom_leap2 = applyZoom_leap2;
            function repaint_leap() {
                me.currPos.x = me.currPos.x + deltaX;
                me.currPos.y = me.currPos.y + deltaY;
                //console.log('deltax '+deltaX);//console.log('deltay '+deltaY);
               // //console.log(me.currPos);
                var newWidth = paper.width * (2 - (me.currZoom * settings.zoomStepLeap)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStepLeap));
                /* 
                if (me.currPos.x < 0) {
                    me.currPos.x = 0;
                } else if (me.currPos.x > (paper.width * me.currZoom * settings.zoomStepLeap)) {
                    me.currPos.x = (paper.width * me.currZoom * settings.zoomStepLeap);
                }
    
                if (me.currPos.y < 0) {
                    me.currPos.y = 0;
                } else if (me.currPos.y > (paper.height * me.currZoom * settings.zoomStepLeap)) {
                    me.currPos.y = (paper.height * me.currZoom * settings.zoomStepLeap);
                }
                */
                //console.log('currposx '+me.currPos.x+' currposy '+me.currPos.y+' newWit '+newWidth+' newHe '+newHeight);
                paper.setViewBox(me.currPos.x, me.currPos.y, newWidth, newHeight);
                //cuman bisa membesar krn newWidth < asli
                
            }
            
            function repaint() {
                me.currPos.x = me.currPos.x + deltaX;
                me.currPos.y = me.currPos.y + deltaY;
    
                var newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep));
                 /*
                if (me.currPos.x < 0) {
                    me.currPos.x = 0;
                } else if (me.currPos.x > (paper.width * me.currZoom * settings.zoomStep)) {
                    me.currPos.x = (paper.width * me.currZoom * settings.zoomStep);
                }*/
                //console.log('batas x > '+(paper.width * me.currZoom * settings.zoomStep));
                /*if (me.currPos.y < 0) {
                    me.currPos.y = 0;
                } else if (me.currPos.y > (paper.height * me.currZoom * settings.zoomStep)) {
                    me.currPos.y = (paper.height * me.currZoom * settings.zoomStep);
                }*/
                //console.log('batas y > '+(paper.height * me.currZoom * settings.zoomStep));
                //console.log('repaint currposx '+me.currPos.x+' currposy '+me.currPos.y+' newWit '+newWidth+' newHe '+newHeight);
                paper.setViewBox(me.currPos.x, me.currPos.y, newWidth, newHeight);
                //cuman bisa membesar krn newWidth < asli
            }
            
            function dragging(e) {
               // return false; //roy
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    newWidth = paper.width * (2 - (me.currZoom * settings.zoomStep)),
                    newHeight = paper.height * (2 - (me.currZoom * settings.zoomStep)),
                    newPoint = getRelativePosition(evt, container);
                   // alert(evt.button); //roy
                if(evt.button != 1)return false;//roy on middle click == dragging, buat touch nanti pikir lagi
                deltaX = (newWidth * (newPoint.x - initialPos.x) / paper.width) * -1;
                deltaY = (newHeight * (newPoint.y - initialPos.y) / paper.height) * -1;
                initialPos = newPoint;
    
                repaint();
                me.dragTime += 1;
                if (evt.preventDefault) {
                    evt.preventDefault();
                } else {
                    evt.returnValue = false;
                }
                return false;
            }
            
            function applyZoom(val, centerPoint) {
                if (!me.enabled) {
                    return false;
                }
                me.currZoom += val;
                if (me.currZoom < settings.minZoom) {
                    me.currZoom = settings.minZoom;
                } else if (me.currZoom > settings.maxZoom) {
                    me.currZoom = settings.maxZoom;
                } else {
                    centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
    
                    deltaX = ((paper.width * settings.zoomStep) * (centerPoint.x / paper.width)) * val;
                    deltaY = (paper.height * settings.zoomStep) * (centerPoint.y / paper.height) * val;
    
                    repaint();
                }
            }
    
            this.applyZoom = applyZoom;
            
            function handleScroll(e) {
                if (!me.enabled) {
                    return false;
                }
                var evt = window.event || e,
                    delta = evt.detail || evt.wheelDelta * -1,
                    zoomCenter = getRelativePosition(evt, container);
    
                if (delta > 0) {
                    delta = -1;
                } else if (delta < 0) {
                    delta = 1;
                }
                
                applyZoom(delta, zoomCenter);
                if (evt.preventDefault) {
                    evt.preventDefault();
                } else {
                    evt.returnValue = false;
                }
                return false;
            }
            
            repaint();
    
            container.onmousedown = function (e) {
                var evt = window.event || e;
                if (!me.enabled) {
                    return false;
                }
                me.dragTime = 0;
                initialPos = getRelativePosition(evt, container);
                container.className += " grabbing";
                container.onmousemove = dragging;
                document.onmousemove = function () { return false; };
                if (evt.preventDefault) {
                    evt.preventDefault();
                } else {
                    evt.returnValue = false;
                }
                return false;
            };
            
            
            container.onmouseup = function (e) {
                //Remove class framework independent
                document.onmousemove = null;
                container.className = container.className.replace(/(?:^|\s)grabbing(?!\S)/g, '');
                container.onmousemove = null;
            };
    
            if (container.attachEvent) {//if IE (and Opera depending on user setting)
                container.attachEvent("on" + mousewheelevt, handleScroll);
            } else if (container.addEventListener) {//WC3 browsers
                container.addEventListener(mousewheelevt, handleScroll, false);
            }
            
            function applyPan(dX, dY) {
                deltaX = dX;
                deltaY = dY;
                repaint();
            }
            
            this.applyPan = applyPan;
        };

    PanZoom.prototype = panZoomFunctions;

    Raphael.fn.panzoom = {};

    Raphael.fn.panzoom = function (options) {
        var paper = this;
        return new PanZoom(paper, options);
    };

}());
