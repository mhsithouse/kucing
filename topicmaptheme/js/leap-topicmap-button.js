              
             /*
            var dxtambah = 0;
            var dytambah = 0;
            
            new Slider({min: 10, max: 100, value: 50})
            .insertTo('my-element').assignTo('my-input')
                .onChange(function(){
                
               // alert(this.value);
              // var vp_x = Math.abs(screen.width/2);
              // var vp_y = Math.abs(screen.height/2);
            //   var wit = parseInt(document.getElementById("holder").style.width);
            //   var heit = parseInt(document.getElementById("holder").style.height);
           var wit = r.width;
           var heit = r.height;
               var vpx = Math.abs(50/this.value)*wit;
               var vpy = Math.abs(50/this.value)*heit;
               dxtambah = vpx;
               dytambah = vpy;
               r.setViewBox(0,0,vpx,vpy,true);
            });*/
            $('change_body_bg_button').onClick(function(){
                
                var slc = $('change_body_bg').value();
                if(slc == "")return false;
                var body = document.getElementsByTagName('body')[0];
                body.style.backgroundImage = 'url('+slc+')';
            });
            
            $('dimension_width_button').onClick(function(){
                var slc = $('dimension_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                if(selected_el.data("dim")=== undefined)return false;
                var dim =  selected_el.data("dim");
                if(selected_el.type == "circle"){
                    selected_el.attr({r: dimensions_circle[slc]});                   
                }
                if(selected_el.type == "rect"){
                    selected_el.attr({width: dimensions_rect[slc],height: dimensions_rect[slc]});                   
                }               
                selected_el.data("dim", slc);
            });
            $('dimension_width').onChange(function(){
                var slc = $('dimension_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                if(selected_el.data("dim")=== undefined)return false;
                var dim =  selected_el.data("dim");
                if(selected_el.type == "circle"){
                    selected_el.attr({r: dimensions_circle[slc]});                   
                }
                if(selected_el.type == "rect"){
                    selected_el.attr({width: dimensions_rect[slc],height: dimensions_rect[slc]});                   
                }               
                selected_el.data("dim", slc);
            });
            
            $('change_stroke_button').onClick(function(){
                var slc = $('stroke_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({stroke: slc});
                selected_el.data("oldstroke", slc);
            });
            $('stroke_color').onChange(function(){
                var slc = $('stroke_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({stroke: slc});
                selected_el.data("oldstroke", slc);
            });
            
            $('change_strokewitdh_button').onClick(function(){
                var slc = $('stroke_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({"stroke-width": slc});
                selected_el.data("oldstrokewit", slc);
            });
            $('stroke_width').onChange(function(){
                var slc = $('stroke_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({"stroke-width": slc});
                selected_el.data("oldstrokewit", slc);
            });
            
            $('change_cc_stroke_button').onClick(function(){
                var slc = $('cc_stroke_color').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({stroke: slc});
                    //r.connection(r_connections[i]);
                }
                default_cc_color = slc;
            });
            $('cc_stroke_color').onChange(function(){
                var slc = $('cc_stroke_color').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({stroke: slc});
                    //r.connection(r_connections[i]);
                }
                default_cc_color = slc;
            });
            $('cc_stroke_width').onChange(function(){
                var slc = $('cc_stroke_width').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({"stroke-width": slc});
                }
                default_stroke_width = slc;
            });
            $('change_cc_strokewitdh_button').onClick(function(){
                var slc = $('cc_stroke_width').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({"stroke-width": slc});
                }
                default_stroke_width = slc;
            });
            $('change_bg_button').onClick(function(){
                var slc = $('change_bg').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                selected_el.attr({fill: "url("+slc+")"});
                selected_el.data("url", slc);
            });
            
            $('tm_bg_color').onChange(function(){
                var slc = $('tm_bg_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({fill: slc});
                selected_el.data("oldbg", slc);
            });
             $('font_color_input').onChange(function(){
                var slc = $('font_color_input').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                 if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){     
                        selected_el.data("texobj").attr({fill: slc});                 
                    }
                }
            });
            $('font_size_input').onChange(function(){
                var slc = $('font_size_input').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                 if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){     
                        selected_el.data("texobj").attr({"font-size": slc});                 
                    }
                }
            });
            $('change_text').onBlur(function(){
                var slc = $('change_text').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                
                if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){
                        
                    
                        console.log(selected_el.data("texobj"));
                        selected_el.data("texobj").remove();                   
                    }
                }
                
                selected_el.data("tex", slc);
                var bb1 = selected_el.getBBox();
                /*
                var postex_x = selected_el.ox+Math.abs(bb1.width/2);
                var postex_y =  selected_el.oy+bb1.height+20;
                if(selected_el.type == "circle") {
                var postex_x = selected_el.ox;font_size_inputfont_size_inputfont_size_input
                var postex_y =  selected_el.oy+Math.abs(selected_el.attr("r")+15);
                } */
                
                var postex_x = bb1.x + Math.abs(bb1.width/2);
                var postex_y = bb1.y + Math.abs(bb1.height/2);
                
                var t = r.text(postex_x,postex_y, slc);
               
                var sizetext = 20;
                
                t.id = "tex_"+selected_el.id;
              //  t.ox = t.ox-Math.abs(bb2.width/2);
                t.attr({"font-size": sizetext,fill: $('font_color_input').value(),"font-size": $('font_size_input').value()});
                selected_el.data("texobj", t);
                 var bb2 =t.getBBox();
                 if(bb2.width >= (bb1.width-5))
                 while(bb2.width >= (bb1.width-5)){                     
                     sizetext--;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();                     
                 }
                 else 
                     while(bb2.width < (bb1.width-15)){
                         if(sizetext>50)break;
                     sizetext++;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
             $('font_size_input').value(sizetext);
                 t.mouseover(hideText);
                console.log(bb2);
                
            });
            $('change_text_button').onClick(function(){
                var slc = $('change_text').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                
                if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){
                        
                    
                        console.log(selected_el.data("texobj"));
                        selected_el.data("texobj").remove();                   
                    }
                }
                
                selected_el.data("tex", slc);
                var bb1 = selected_el.getBBox();
                /*
                var postex_x = selected_el.ox+Math.abs(bb1.width/2);
                var postex_y =  selected_el.oy+bb1.height+20;
                if(selected_el.type == "circle") {
                var postex_x = selected_el.ox;
                var postex_y =  selected_el.oy+Math.abs(selected_el.attr("r")+15);
                } */
                
                var postex_x = bb1.x + Math.abs(bb1.width/2);
                var postex_y = bb1.y + Math.abs(bb1.height/2);
                
                var t = r.text(postex_x,postex_y, slc);
               
                var sizetext = 20;
                
                t.id = "tex_"+selected_el.id;
              //  t.ox = t.ox-Math.abs(bb2.width/2);
                t.attr({"font-size": sizetext});
                selected_el.data("texobj", t);
                 var bb2 =t.getBBox();
                 if(bb2.width >= (bb1.width-5))
                 while(bb2.width >= (bb1.width-5)){                     
                     sizetext--;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
                 else 
                     while(bb2.width < (bb1.width-5)){
                         if(sizetext>50)break;
                     sizetext++;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
                 t.mouseover(hideText);
                console.log(bb2);
                
            });