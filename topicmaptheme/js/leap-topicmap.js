
Raphael.fn.connection = function (obj1, obj2, line, bg) {
    if (obj1.line && obj1.from && obj1.to) {
        line = obj1;
        obj1 = line.from;
        obj2 = line.to;
    }
    var bb1 = obj1.getBBox(),
        bb2 = obj2.getBBox(),
        p = [{x: bb1.x + bb1.width / 2, y: bb1.y - 1},
        {x: bb1.x + bb1.width / 2, y: bb1.y + bb1.height + 1},
        {x: bb1.x - 1, y: bb1.y + bb1.height / 2},
        {x: bb1.x + bb1.width + 1, y: bb1.y + bb1.height / 2},
        {x: bb2.x + bb2.width / 2, y: bb2.y - 1},
        {x: bb2.x + bb2.width / 2, y: bb2.y + bb2.height + 1},
        {x: bb2.x - 1, y: bb2.y + bb2.height / 2},
        {x: bb2.x + bb2.width + 1, y: bb2.y + bb2.height / 2}],
        d = {}, dis = [];
    for (var i = 0; i < 4; i++) {
        for (var j = 4; j < 8; j++) {
            var dx = Math.abs(p[i].x - p[j].x),
                dy = Math.abs(p[i].y - p[j].y);
            if ((i == j - 4) || (((i != 3 && j != 6) || p[i].x < p[j].x) && ((i != 2 && j != 7) || p[i].x > p[j].x) && ((i != 0 && j != 5) || p[i].y > p[j].y) && ((i != 1 && j != 4) || p[i].y < p[j].y))) {
                dis.push(dx + dy);
                d[dis[dis.length - 1]] = [i, j];
            }
        }
    }
    if (dis.length == 0) {
        var res = [0, 4];
    } else {
        res = d[Math.min.apply(Math, dis)];
    }
    var x1 = p[res[0]].x,
        y1 = p[res[0]].y,
        x4 = p[res[1]].x,
        y4 = p[res[1]].y;
    dx = Math.max(Math.abs(x1 - x4) / 2, 10);
    dy = Math.max(Math.abs(y1 - y4) / 2, 10);
    var x2 = [x1, x1, x1 - dx, x1 + dx][res[0]].toFixed(3),
        y2 = [y1 - dy, y1 + dy, y1, y1][res[0]].toFixed(3),
        x3 = [0, 0, 0, 0, x4, x4, x4 - dx, x4 + dx][res[1]].toFixed(3),
        y3 = [0, 0, 0, 0, y1 + dy, y1 - dy, y4, y4][res[1]].toFixed(3);
    var path = ["M", x1.toFixed(3), y1.toFixed(3), "C", x2, y2, x3, y3, x4.toFixed(3), y4.toFixed(3)].join(",");
    if (line && line.line) {
        line.bg && line.bg.attr({path: path});
        line.line.attr({path: path});
    } else {
        var color = typeof line == "string" ? line : "#000";
        return {
            bg: bg && bg.split && this.path(path).attr({stroke: bg.split("|")[0], fill: "none", "stroke-width": bg.split("|")[1] || 3}),
            line: this.path(path).attr({stroke: color, fill: "none","stroke-width": default_stroke_width}),
            from: obj1,
            to: obj2
        };
    }
};
Array.prototype.move = function (old_index, new_index) {
    if (new_index >= this.length) {
        var k = new_index - this.length;
        while ((k--) + 1) {
            this.push(undefined);
        }
    }
    this.splice(new_index, 0, this.splice(old_index, 1)[0]);
    return this; // for testing purposes
};
Array.prototype.swap = function (x,y) {
  var b = this[x];
  this[x] = this[y];
  this[y] = b;
  return this;
}
function checkURL(url) {
    return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}
function slide_move_up(id){
    
   // alert(id);
    var c = r.getById(id);
    if(c.data("urutan") == 1)return false;
    if(c.data("urutan")< 1)return false;
    var urutanasli = parseInt(c.data("urutan"));
    var yangdicari = parseInt(c.data("urutan"))-1;
    var len = ralp_register_id.length;
    var keyganti = 0;var keylama = 0;
    for(key=0;key<len;key++){
        if(parseInt(ralp_register_id[key].data("urutan")) == yangdicari){
            keyganti = key;
           // ralp_register_id[key].data("urutan",urutanasli);
           // //console.log('yangdicari'); //console.log(ralp_register_id[key]);
        }
        if(parseInt(ralp_register_id[key].data("urutan")) == urutanasli){
            keylama = key;
           // ralp_register_id[key].data("urutan",yangdicari);
           // //console.log('aslinya'); //console.log(ralp_register_id[key]);
        }
    }
    ralp_register_id[keyganti].data("urutan",urutanasli);
    ralp_register_id[keylama].data("urutan",yangdicari);
    ralp_register_id.swap(keylama,keyganti);
    ralp_register_id_asli.swap(keylama,keyganti);
    updateSlide();
}
function slide_move_down(id){
    var len = ralp_register_id.length;
    var maxindex = len-1;
   // alert(id);
    var c = r.getById(id);
    if(c.data("urutan") == maxindex)return false;
    if(c.data("urutan")> maxindex)return false;
    var urutanasli = parseInt(c.data("urutan"));
    var yangdicari = parseInt(c.data("urutan"))+1;
    
    var keyganti = 0;var keylama = 0;
    for(key=0;key<len;key++){
        if(parseInt(ralp_register_id[key].data("urutan")) == yangdicari){
            keyganti = key;
           // ralp_register_id[key].data("urutan",urutanasli);
            //console.log('yangdicari'); //console.log(ralp_register_id[key]);
        }
        if(parseInt(ralp_register_id[key].data("urutan")) == urutanasli){
            keylama = key;
           // ralp_register_id[key].data("urutan",yangdicari);
            //console.log('aslinya'); //console.log(ralp_register_id[key]);
        }
    }
    ralp_register_id[keyganti].data("urutan",urutanasli);
    ralp_register_id[keylama].data("urutan",yangdicari);
    ralp_register_id.swap(keylama,keyganti);
    ralp_register_id_asli.swap(keylama,keyganti);
    updateSlide();
}
function updateSlide(){
    var len = ralp_register_id.length;
    $('sortable_slide').html('');
    var c;
    for(key=0;key<len;key++){
        c = ralp_register_id[key];
         InsertSlide(c);      
    }
}
function InsertSlide(c){
       $('sortable_slide').insert("<div id='slide_"+c.data("urutan")+"'><span id='slide_isi_"+c.data("urutan")+"'>"+c.data("urutan")+"."+c.data("tex")+"</span> <span onclick='slide_move_up(\""+c.id+"\");'>up</span> <span onclick='slide_move_down(\""+c.id+"\");'>down</span></div>");     
   } 
function createTextElement(el,tex,fontsize,fontcolor){
    var bb1;var postex_x;var postex_y;var t;
    //alert('in');
    el.data("tex", tex);
   /* if(el.type == "rect") {
    bb1 = el.getBBox();
    postex_x = el.attr("x")+Math.abs(bb1.width/2);
    postex_y =  el.attr("y")+bb1.height+20;
    }
    if(el.type == "circle") {
    postex_x = el.attr("cx");
    postex_y =  el.attr("cy")+Math.abs(el.attr("r")+15);
    }*/ 
    bb1 = el.getBBox();
    var postex_x = bb1.x + Math.abs(bb1.width/2);
    var postex_y = bb1.y + Math.abs(bb1.height/2);
                
    ////console.log("ox "+el.attr("cx"));
    ////console.log("oy "+el.oy);
    t = r.text(postex_x,postex_y, tex);
    ////console.log(t);
    //var bb2 =t.getBBox();
    t.id = "tex_"+el.id;
  //  t.ox = t.ox-Math.abs(bb2.width/2);
    t.attr({"font-size": fontsize});
    t.attr({"fill": fontcolor});
    if($('slide_isi_'+el.data("urutan"))!== null)
    $('slide_isi_'+el.data("urutan")).html(el.data("urutan")+'.'+tex.replace(/(\r\n|\n|\r)/gm," "));
    el.data("texobj", t);
     t.mouseover(hideText);
     updateSlide();
}
function tambahrect(cid){
     var c;
    // var x=event.screenX;
    // var y=event.screenY;
     var mouseX = event.pageX; 
     var mouseY = event.pageY;
     //alert('in'+mouseX);
     mouseX += 100;
     mouseY += 100;
     craphael = r.rect(mouseX, mouseY, dimensions_rect[default_size], dimensions_rect[default_size], 10);
     c = craphael;
     c.attr({fill: default_fill_color, stroke: default_stroke_color,"fill-opacity": 1, "stroke-width": default_stroke_width, cursor: "move"});
     c.id = cid;
     c.data("tex","no");
     c.data("urutan",getUrutan());
     c.data("dim", 2);
     jumlahel++;
     latest_el = c;
     ralp_register_id.push(c);
     ralp_register_id_asli.push(c.id);
     c.drag(r_move,r_dragger,r_up);
     c.dblclick(el_dbl_click);
     c.mouseover(lessOpacity);
     c.mouseout(showText);
     updateSlide(); 
}
function tambahcircle(cid){
     var c;
           // var x=event.screenX;
	   // var y=event.screenY;
            var mouseX = event.pageX; 
            var mouseY = event.pageY;
            //alert('in'+mouseX);
            mouseX += 100;
            mouseY += 100;
            craphael = r.circle(mouseX, mouseY, dimensions_circle[default_size]);
            c = craphael;
            c.attr({fill: default_fill_color, stroke: default_stroke_color,"fill-opacity": 1, "stroke-width": default_stroke_width, cursor: "move"});
            c.id = cid;
            c.data("tex","no");
            
            c.data("urutan",getUrutan());
            c.data("dim", 2);
            jumlahel++;
            latest_el = c;
            ralp_register_id.push(c);
            ralp_register_id_asli.push(c.id);
            c.drag(r_move,r_dragger,r_up);
            c.dblclick(el_dbl_click);
            c.mouseover(lessOpacity);
            c.mouseout(showText);
            updateSlide();
}



function width(){
   return window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth||0;
}
function height(){
   return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;
}



var ralp_register_id = new Array();
var ralp_register_id_asli = new Array();
var mau_di_link_id = new Array();
var mau_di_link_id_asli = new Array();
var r_connections = new Array();
var r_connections_a_b = new Array();
var craphael;
var jumlahel = 0;
var selected_el;
var latest_el;
var default_fill_color = "#ffff00";
var default_stroke_color = "#fff0ff";
var default_cc_color = "#2e81dc";
var default_stroke_width = 2;
var default_size = 2;
var default_fontsize = 15;
var default_fontcolor = "#000000";

var dimensions_rect = [ 40,60,85,100,120,150,180,200,250,300];
var dimensions_circle = [ 20,30,45,55,60,75,90,100,125,150];
function r_dragger() {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        this.animate({"fill-opacity": .2}, 300);
        
    }
function r_move(dx, dy) {
  //  dx = dx+dxtambah; dy = dy+dytambah;
   // alert('move');
  var att = this.type == "rect" ? {x: this.ox + dx, y: this.oy + dy} : {cx: this.ox + dx, cy: this.oy + dy};
  this.attr(att);
  if(this.data("tex")!="no"){
      if(this.data("texobj") !== undefined && this.data("tex") !== undefined){
          
            ////console.log(this.data("texobj"));
            var bb1 = this.getBBox();
            var postex_x = this.ox + Math.abs(bb1.width/2);
           var postex_y = this.oy + Math.abs(bb1.height/2);
           if(this.type == "circle") {
                var postex_x = this.ox;
                var postex_y = this.oy;
            }     
           // var postex_x = this.ox+Math.abs(bb1.width/2);
           // var postex_y =  this.oy+bb1.height+20;
           // var t = r.text(postex_x,postex_y, slc);
            //var bb2 =this.data("texobj").getBBox();
            //t.id = "tex_"+selected_el.id;
           // postex_x = postex_x-Math.abs(bb2.width/2);
           // if(this.type == "circle") {
           //     var postex_x = this.ox;
           //     var postex_y =  this.oy+Math.abs(this.attr("r")+15);
           // }  
            this.data("texobj").attr({x:postex_x+ dx,y:postex_y+ dy});
            
           
        }
   }
  for (var i = r_connections.length; i--;) {
      r.connection(r_connections[i]);
  }
  var newx = parseFloat(this.ox)+parseFloat(dx);
  var newy = parseFloat(this.oy)+parseFloat(dy);
  $('posisi').html('x:'+newx+' y:'+newy+' id :'+this.id);
  r.safari();
}
function r_up() {
    //this.animate({"fill-opacity": 1}, 300);    
    updatecolor();
}

  function rconnect(){
            if(mau_di_link_id.length>2){ alert("Choose 2 Elements");return 0;}
            if(mau_di_link_id.length!=2){ alert("Choose 2 Elements");return 0;}
            if(mau_di_link_id[0] ==  null || mau_di_link_id[1] == null)return 0;
            
            var ac = mau_di_link_id[0].id+"___"+mau_di_link_id[1].id;  
            var ad = mau_di_link_id[1].id+"___"+mau_di_link_id[0].id;
            if(in_array(ac,r_connections_a_b)||in_array(ad,r_connections_a_b))
            {
               alert('Link Already Made'); return 0;
            }
            var con = r.connection(mau_di_link_id[0], mau_di_link_id[1], default_cc_color);
            r_connections.push(con);
            
            
                               
            r_connections_a_b.push(ac);
            
            mau_di_link_id.length = 0;
            mau_di_link_id_asli.length = 0;
            updatecolor();
        }
        var removeStatus = 0;
        function rem_rconnect(){
            if(mau_di_link_id.length>2){ alert("Choose 2 Elements");return 0;}
            if(mau_di_link_id.length!=2){ alert("Choose 2 Elements");return 0;}
            if(mau_di_link_id[0] ==  null || mau_di_link_id[1] == null)return 0;
            var ac = mau_di_link_id[0].id+"___"+mau_di_link_id[1].id;
            var ca = mau_di_link_id[1].id+"___"+mau_di_link_id[0].id;
            ////console.log(r_connections);
            var key;
            for(key in r_connections_a_b){
                if(key<r_connections_a_b.length)
                if(r_connections_a_b[key]==ac || r_connections_a_b[key]==ca ){
                    r_connections[key].line.remove();
                    r_connections.splice(key,1);
                    r_connections_a_b.splice(key,1);
                    removeStatus = 1;
                }                
                //r_connections_a_b[key].remove();
            }
            if(removeStatus){
            mau_di_link_id.length = 0;
            mau_di_link_id_asli.length = 0;
            updatecolor();
            removeStatus = 0;
            }
            else{
                alert('No Link Deleted'); return 0;
            }
        }
        function rem_rel(){
            if(mau_di_link_id.length>1){ alert("Please Choose One Object");return 0;}
            if(mau_di_link_id.length!=1){ alert("Please Choose an Object");return 0;}
            if(mau_di_link_id[0] ==  null){ alert("Please Choose an Object");return 0;}
           
            //hilangkan di register juga
            var key;
            var len = ralp_register_id_asli.length;
            for(key=0;key<len;key++){
            //for(key in ralp_register_id_asli){
                if(key<ralp_register_id_asli.length){
                    var cid = ralp_register_id_asli[key];
                    if(cid == mau_di_link_id_asli[0])
                    {
                        //delete its text object first
                        if(mau_di_link_id[0].data("texobj") !== undefined ){
                            mau_di_link_id[0].data("texobj").remove();
                        }
                        ralp_register_id_asli.splice(key,1);
                        ralp_register_id.splice(key,1);
                        mau_di_link_id[0].remove();
                        mau_di_link_id.splice(0,1);
                        mau_di_link_id_asli.splice(0,1);
                        mau_di_link_id.length = 0;
                        mau_di_link_id_asli.length = 0;
                        delete_connections(cid);
                        
                    }
                }
            }
            //console.log("after delete");
            //console.log(ralp_register_id_asli);
            //console.log(mau_di_link_id_asli);
            //console.log("koneksi");
            //console.log(r_connections_a_b);
            updateSlide(); 
            //updatecolor();
        }
        function delete_connections(id){
            //var id = ralp_register_id_asli[k];
            //console.log("delete connection");
            //console.log(id);
            //console.log(r_connections_a_b);
            if(id ===undefined)return 0;
           // if(r_connections_a_b.length>0)
            var key2;
            var len = r_connections_a_b.length;
            //console.log("len "+len);
            var array_sem = new Array();
            var array_sem_con = new Array();
            for(x=0;x<len;x++){
			
           /* for(key2 in r_connections_a_b){
                if(key2 == "first")continue;
                if(key2 == "last")continue;
                if(key2 == "random")continue;
                if(key2 == "size")continue;
                if(key2 == "clean")continue;*/
                //if(key2<len){
                    //console.log("key "+x); 
                    var arr = r_connections_a_b[x].split("___");
                     //console.log("arr "+x); //console.log(arr);
                    
                    if(id == arr[0] || id == arr[1]){
                        
                        r_connections[x].line.remove();
                        //r_connections.splice(x,1);
                        //r_connections_a_b.splice(x,1);
                    }else{
                        array_sem.push(r_connections_a_b[x]);
                        array_sem_con.push(r_connections[x]);
                    }
                    //console.log("danach"); 
               // }
                //r_connections_a_b[key].remove();
            }
            r_connections_a_b = array_sem;
            r_connections = array_sem_con;
            //return 1;
        
        }
        function delete_satu(k){
            r_connections[k].line.remove();
            r_connections.splice(k,1);
            r_connections_a_b.splice(k,1);
        }
   
 function el_dbl_click(){
    
                
                if(!in_array(this.id,mau_di_link_id_asli)){
                                        
                    if(mau_di_link_id_asli.length >1){
                        mau_di_link_id.shift();
                        mau_di_link_id_asli.shift();
                        //mau_di_link_id[0] = this;
                       // mau_di_link_id_asli[0] = this.id;
                    }
                    //this.attr({fill: "#fff000"});
                    mau_di_link_id.push(this);
                    mau_di_link_id_asli.push(this.id);
                    
                    // kl blom di klik diganti ke yang ini focusnya
                    selected_el = this;
                    
                    reset_info_box();
                }
                else{
                    //this.attr({fill: "#f00000"});
                    for (key in mau_di_link_id_asli) {
                        if(mau_di_link_id_asli[key] == this.id){
                            mau_di_link_id.splice(key,1);
                            mau_di_link_id_asli.splice(key,1);
                            //console.log("in1");
                            // kalau kliknya dihilangkan selectednya dipindah ke yang masih kuning ... sebelumnya
                            if(mau_di_link_id.length>0){
                                 //console.log("in2"+mau_di_link_id.length);
                                if(mau_di_link_id[(mau_di_link_id.length-1)] !== undefined){
                                    selected_el = mau_di_link_id[(mau_di_link_id.length-1)];
                                    reset_info_box(); 
                                }
                            }
                            else{
                               document.getElementById('select-info').style.display = 'none'; 
                                //tidak ada yg mw dilink
                           }
                        }
                    }
                    //mau_di_link_id.splice((mau_di_link_id.length-1),1);
                }
                 //console.log(ralp_register_id_asli);
                 //console.log(mau_di_link_id_asli);
                //$('isiarr').html(mau_di_link_id_asli.join(","));
                //$('isiarr2').html(ralp_register_id_asli.join(","));
                updatecolor();
                
               
            
 }
 var inDarkness = 0;
    function darkenbackground(){
        $("overlaybox").addClass('overlay');
        var key;
        for(key in r_connections_a_b){
            if(key<r_connections_a_b.length)
                 r_connections[key].line.animate({"stroke-opacity":.3}, 300);                          
            //r_connections_a_b[key].remove();
        }
        inDarkness =1;
            
    }
    function normalbackground(){
        $("overlaybox").removeClass('overlay');
        var key;
        for(key in r_connections_a_b){
            if(key<r_connections_a_b.length)
                 r_connections[key].line.animate({"stroke-opacity":1}, 300);                          
            //r_connections_a_b[key].remove();
        }
        inDarkness = 0;
    }
    
  
    
var arr_occ = new Array();
var id_occ = 1;
function updateocc(selid){
    $('occ_holder').html('');
    //console.log(arr_occ);

    for(var i=0;i<arr_occ.length;i++){
        if(arr_occ[i].id == selid)
        $('occ_holder').html($('occ_holder').html()+arr_occ[i].oic+'  '+arr_occ[i].name);
    }
}

 function reset_info_box(){
    document.getElementById('select-info').style.display = '';
    if(selected_el.data("tex")!="no"){
        if(selected_el.data("texobj") !== undefined && selected_el.data("tex") !== undefined){
            $('change_text').value(selected_el.data("tex"));  
            $('font_color_input').value(selected_el.data("texobj").attr("fill"));
            $('font_size_input').value(selected_el.data("texobj").attr("font-size"));
        }
        else{ $('change_text').value("");$('font_color_input').value(default_fontcolor);
        $('font_size_input').value(default_fontsize); }
    }
    else{ $('change_text').value("");$('font_color_input').value(default_fontcolor);
        $('font_size_input').value(default_fontsize); }
        
    if(selected_el.attr("stroke")!== undefined)
    $('tm_bg_color').value(selected_el.attr("fill"));
    else
    $('tm_bg_color').value(default_fill_color);
    
/*
    if(selected_el.data("url") !== undefined){
            $('change_bg').value(selected_el.data("url"));                 
           
    } else        
         $('change_bg').value("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoX4VTR25ACLBrTGZmnh9gQGa1KK-AJfjVxMgARjlRTLa9miOzoy3jYQ");  
     */
    if(selected_el.attr("stroke")!== undefined)
    $('stroke_color').value(selected_el.attr("stroke"));
    if(selected_el.attr("stroke-width")!== undefined)
    $('stroke_width').value(selected_el.attr("stroke-width"));
    if(selected_el.data("dim")!== undefined)
    $('dimension_width').value(selected_el.data("dim"));
    updateocc(selected_el.id);
}

function getLatestID(){
    var len = ralp_register_id_asli.length;
    var max = 0;
    for(key=0;key<len;key++){
        var arr = ralp_register_id_asli.split('_');
        if(arr[1]>max)max = arr[1];
    }
    return max++;
}

function getUrutan(){
    var urut = ralp_register_id_asli.length+1;
    return urut;    
}

function hideText(){
    this.toBack();
}
function showText(){
    if(this.data("tex")!="no"){
        if(this.data("texobj") !== undefined && this.data("tex") !== undefined){
            this.data("texobj").toFront();
        }                  
    }
    if(!inDarkness)
    this.animate({"fill-opacity": 1}, 300);
}
function lessOpacity(){
    if(!inDarkness)
    this.animate({"fill-opacity": .8}, 300);
}
function updatecolor(){
             updateSlide();
$('rem_selected_obj').removeClass("butonaktiv");
 $('link_selected_obj').removeClass("butonaktiv");
 $('rem_link_selected_obj').removeClass("butonaktiv");
                        
            $('isiarr').html(mau_di_link_id_asli.join(","));
            $('isiarr2').html(ralp_register_id_asli.join(","));
           // //console.log(ralp_register_id);
           var key;
           if(ralp_register_id_asli.length>0)
            for(key in ralp_register_id_asli){
                if(key<ralp_register_id_asli.length){
                    var cid = ralp_register_id_asli[key];
                   // //console.log("cid "+cid);
                    
                    //craphael = r.getById(cid);
                 /*   if(r.getById(cid).data("oldstroke")!== undefined)
                        r.getById(cid).attr({ stroke: r.getById(cid).data("oldstroke")});
                    else
                        r.getById(cid).attr({ stroke: "#dedede"});
                   */ 
                    if(mau_di_link_id_asli.length>0){
                        darkenbackground();
                        if(in_array(cid,mau_di_link_id_asli))
                        {   
                            //simpan warna lama ...
                         //   r.getById(cid).data("oldstroke",r.getById(cid).attr("stroke"));
                         //   r.getById(cid).data("oldstrokewit",r.getById(cid).attr("stroke-width"));
                            //add selection
                         //   r.getById(cid).attr({ stroke: "#fff000"});
                           if(selected_el.id!=cid){
                               r.getById(cid).animate({"fill-opacity": .6,"stroke-opacity":.6}, 300);
                              //r.getById(cid).click(function(){selected_el = this;updatecolor();reset_info_box(); });
                           }else
                              r.getById(cid).animate({"fill-opacity": 1,"stroke-opacity":1}, 300); 
                        }
                        else{
                             r.getById(cid).animate({"fill-opacity": 0,"stroke-opacity":0.3}, 300);
                        }
                    }else{                                                
                        r.getById(cid).animate({"fill-opacity": 1,"stroke-opacity":1}, 300);
                        normalbackground();
                        document.getElementById('select-info').style.display = 'none';
                    }
                    
                    
                    if(mau_di_link_id_asli.length==1){
                        $('rem_selected_obj').addClass("butonaktiv");
                    }
                    if(mau_di_link_id_asli.length==2){
                        $('link_selected_obj').addClass("butonaktiv");
                        $('rem_link_selected_obj').addClass("butonaktiv");   
                        var ac = mau_di_link_id[0].id+"___"+mau_di_link_id[1].id;
                        var ca = mau_di_link_id[1].id+"___"+mau_di_link_id[0].id;
                        ////console.log(r_connections);
                        var key;
                        for(key in r_connections_a_b){
                            if(key<r_connections_a_b.length)
                            if(r_connections_a_b[key]==ac || r_connections_a_b[key]==ca ){
                                r_connections[key].line.animate({"stroke-opacity":1}, 300);                             
                            }                
                            //r_connections_a_b[key].remove();
                        }
                    }
                    
                   /* else{
                        //remove selection
                        r.getById(cid).attr({ stroke: "#dedede","fill-opacity": 1, "stroke-width": 2, cursor: "move"});
                        
                    }*/
                }
            }
            
        }
        
       
   function eventFire(el, etype){
        if (el.fireEvent) {
          (el.fireEvent('on' + etype));
        } else {
          var evObj = document.createEvent('Events');
          evObj.initEvent(etype, true, false);
          el.dispatchEvent(evObj);
        }
      }



function getInNav(evt,paper,c){
    
    var  container = paper.canvas.parentNode;
    var centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
    
    var zoomCenter = getRelativePositionLeap(evt, container);
     
    var val = 1 || c.data("zoom");
     val = parseInt(c.data("zoom"));
     var bb1 = c.getBBox(true);
     var bb2 = c.getBBox();
    // var bb2 = c.getClientBoundingRect();
     var mouseX = evt.pageX; 
     var mouseY = evt.pageY;
            
    //console.log('mouse xy : '+mouseX+' '+mouseY);
    //console.log('bb : '+bb1);//console.log(bb2);
    //console.log('zoom inside '+c.data("zoom"));
    //console.log('zoomval inside '+val);
    panZoom.panTo(evt,c);
    
   // zoomCenter = {x : bb1.cx, y:bb1.cy};
   //if(val == -1)
   zoomCenter = { x: screen.width / 2, y: screen.height / 2 };
   
   //zoomCenter =panZoom.zoomcenterleap(evt,c);
   
    if(!panZoom.applyZoom_leap(val, zoomCenter)){
        //zoomCenter = getRelativePositionLeap(evt, container);
        panZoom.panTo(evt,c);
        if(val==1)zoomInPush(evt,c);
        //$('desc_'+c.id).fade();
        if(val==1)$('desc_'+c.id).fade('in');
        if(val== -1)$('desc_'+c.id).hide();
        clearTimeout(myZoom);
        endAni = 1;
    }else{
        setTimeout(function(){getInNav(evt,paper,c)},LeapDuration);
        LeapDuration = LeapDuration-5;
    }
    
}
var myZoom;
var myPan;
var endAni = 0;
var LeapDuration = 50;
var simclickOn = 0;
function zoomTimer(evt,paper,c) {
    endAni = 0;
    LeapDuration = 50;
    
    if(c.data("texobj")!== null && c.data("texobj")!== undefined){
        if(c.data("zoom") == 1)
        c.data("texobj").animate({"fill-opacity": 0}, 500);
        else{
            c.data("texobj").animate({"fill-opacity": 1}, 500);
            setAllDesToNone();
        }
    }
    myZoom = setTimeout(function(){getInNav(evt,paper,c)},LeapDuration);  
}
function setAllDesToNone(){
    var len = ralp_register_id.length;
    var c;
    for(key=0;key<len;key++){
        c = ralp_register_id[key];
        $('desc_'+c.id).hide('');
         if(c.data("texobj")!== null && c.data("texobj")!== undefined){
             c.data("texobj").toFront();
             c.data("texobj").animate({"fill-opacity": 1}, 10);
         }
    }
}
function panTimer(evt,paper,c) {
    endAni = 0;
    LeapDuration = 50;
    panZoom.fixTujuan(evt,c);
    panZoom.resetPanLvl();
    myPan = setTimeout(function(){getPanCenter(evt,paper,c)},LeapDuration);  
  //panZoom.panTo(evt,c); 
}

function getPanCenter(evt,paper,c){
    
    
    if(panZoom.slowpanTo(evt,c)){
        //zoomCenter = getRelativePositionLeap(evt, container);
       // panZoom.panTo(evt,c);
       zoomTimer(evt,paper,c);
      
        clearTimeout(myPan);
        endAni = 1;
    }else{
        
        setTimeout(function(){getPanCenter(evt,paper,c)},LeapDuration);
        LeapDuration = LeapDuration-5;
    }
    
}
 function getRelativePositionLeap(e, obj) {
        var x, y, pos;
        if (e.pageX || e.pageY) {
            x = e.pageX;
            y = e.pageY;
        } else {
            x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }

        pos = findPosLeap(obj);
        //console.log(pos);
        x -= pos[0];
        y -= pos[1];
        //console.log('xy : '+x+' '+y);
        return { x: x, y: y };
    }
    
    function findPosLeap(obj) {
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
    
    function simClick(c,evt){
        
        /*if(c.data("zoom")=== undefined){
            c.data("zoom", 1);
        }else{
            if(parseInt(c.data("zoom"))== -1)c.data("zoom", 1);
            else c.data("zoom", -1); 
        }*/
        c.data("zoom", 1);
        ////console.log('zoom '+c.data("zoom"));
        simclickOn = 1;
        //panZoom.panTo(evt,c);        
        //zoomTimer(evt,r,c);
        panTimer(evt,r,c);
    }
    
function zoomOutDikit(c,evt) {
    endAni = 0;
    LeapDuration = 50;
    c.data("zoom", -1);
    if(c.data("texobj")!== null && c.data("texobj")!== undefined){c.data("texobj").animate({"fill-opacity": 1}, 500);}
    myZoom = setTimeout(function(){zoomDikitFkt(c,evt)},LeapDuration);  
}
function zoomDikitFkt(c,evt){
    
   // var  container = paper.canvas.parentNode;
   // var centerPoint = centerPoint || { x: paper.width / 2, y: paper.height / 2 };
    
   // var zoomCenter = getRelativePositionLeap(evt, container);
     //console.log('prev '+prevslide+' current '+curentslide);
     //console.log(c);
  //  var val = 1 || c.data("zoom");
   var val = parseInt(c.data("zoom"));
   //  var bb1 = c.getBBox(true);
   //  var bb2 = c.getBBox();
   // // var bb2 = c.getClientBoundingRect();
  //   var mouseX = evt.pageX; 
   //  var mouseY = evt.pageY;
            
   // //console.log('mouse xy : '+mouseX+' '+mouseY);
   // //console.log('bb : '+bb1);//console.log(bb2);
  //  //console.log('zoom inside '+c.data("zoom"));
   // //console.log('zoomval inside '+val);
    panZoom.panTo(evt,c);
    
   // zoomCenter = {x : bb1.cx, y:bb1.cy};
   //if(val == -1)
  var zoomCenter = { x: screen.width / 2, y: screen.height / 2 };
   
   //zoomCenter =panZoom.zoomcenterleap(evt,c);
  // panZoom.applyZoom_leap2(-1, zoomCenter);
  // panZoom.applyZoom_leap2(-1, zoomCenter);
  // panZoom.applyZoom_leap2(1, zoomCenter);
    if(!panZoom.applyZoom_leap2(val, zoomCenter)){
        //zoomCenter = getRelativePositionLeap(evt, container);
        panZoom.panTo(evt,c);
        $('desc_'+c.id).fade('out');
        clearTimeout(myZoom);
        endAni = 1;
        simClick(ralp_register_id[curentslide],evt);
    }else{
        setTimeout(function(){zoomDikitFkt(c,evt)},LeapDuration);
        LeapDuration = LeapDuration-5;
    }
    
}

 

function nextslidefkt(evt){
    
                var len = ralp_register_id.length;
                slidemode = 1;
                //alert('in');
                if(slidenow < 1){                  
                    simClick(ralp_register_id[0],evt);                   
                    slidenow++;
                    prevslide = 0;
                    nextslide = 1;
                    curentslide = 0;
                }
                else if(slidenow<len){
                    curentslide = slidenow;
                    //if(prevslide == "")
                    //    simClick(ralp_register_id[0],evt);
                   // else{
                        zoomOutDikit(ralp_register_id[prevslide],evt);
                            // do nothing                                              
                   // }
                    prevslide = slidenow;
                    slidenow++;
                    nextslide = slidenow;
                    //simClick(ralp_register_id[slidenow],evt);
                    //slidenow++;
                }
                else{
                   /* slidemode = 0;slidenow = 0;nextslide = "";
                    prevslide = "";curentslide = 0;
                    ralp_register_id[0].data("zoom", -1);
                    zoomTimer(evt,r,ralp_register_id[0]);
                    */
                    returnToNormalState(evt);
                    
                    //simClick(ralp_register_id[0],evt);
                    //slidenow++;
                }
                
                
            
}
function returnToNormalState(evt){
    ralp_register_id[0].data("zoom", -1);
    setAllDesToNone();
    panTimer(evt,r,ralp_register_id[0]);
    slidenow = 0;
    
    //zoomTimer(evt,r,ralp_register_id[0]);
}
function prevslidefkt(evt){
    var len = ralp_register_id.length;
                slidemode = 1;
                //alert('in');
                if(slidenow < 1){
                   
                  //  slidemode = 0;slidenow = 0;nextslide = 1;
                   // prevslide = -1;curentslide = 0;
                   // ralp_register_id[0].data("zoom", -1);
                   // zoomTimer(evt,r,ralp_register_id[0]);
                    
                    returnToNormalState(evt);
                    
                }
                else{
                    
                    curentslide = slidenow-2;
                    //if(prevslide == "")
                    //    simClick(ralp_register_id[0],evt);
                   // else{
                    zoomOutDikit(ralp_register_id[slidenow-1],evt);
                            // do nothing                                              
                   // }
                    prevslide = slidenow-2;                   
                    nextslide = slidenow;
                    slidenow = slidenow-1;
                    
                    //simClick(ralp_register_id[slidenow],evt);
                    //slidenow++;
                }
}

function zoomInPush(evt,c){
    var bb = c.getBBox();
    console.log(bb);
    var newx,newy;
     var neww = r.width/25;
    var newh = r.height/25;
    newx = bb.cx-neww/2;
    newy = bb.cy-newh/2;
    //c.data("texobj").animate({"fill-opacity": .2}, 500);
    r.setViewBox(newx, newy, neww, newh);
    
}

function addslashes(str) {
  //  discuss at: http://phpjs.org/functions/addslashes/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Ates Goral (http://magnetiq.com)
  // improved by: marrtins
  // improved by: Nate
  // improved by: Onno Marsman
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Oskar Larsson Högfeldt (http://oskar-lh.name/)
  //    input by: Denny Wardhana
  //   example 1: addslashes("kevin's birthday");
  //   returns 1: "kevin\\'s birthday"

  return (str + '')
    .replace(/[\\"']/g, '\\$&')
    .replace(/\u0000/g, '\\0');
}

function showNPButton(){
     $('nextbuttonholder').slide({direction: 'top'});
}
function hideNPButton(){
    $('nextbuttonholder').slide({direction: 'top'});
}
function dragtouch() {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        this.animate({"fill-opacity": .2}, 300);
        alert('hi'+this.id);
    }
    
    
    //(grabmove,grabdragger,grabup);
function grabdragger() {
    //this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
    //this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
    //this.animate({"fill-opacity": .2}, 300);

}
var awalx = 0;
var awaly = 0;
function grabmove(dx, dy) {
    if(awalx == 0){
        awalx = dx*(-1);
        awaly = dy*(-1);
    }
    else{
        awalx = endex+(dx*(-1));
        awaly = endey+(dy*(-1));
    }
    r.setViewBox(awalx, awaly, r.width, r.height);   
    r.safari();
}
function grabmoveHammer(dx, dy) {
    if(awalx == 0){
        awalx = dx*(-1);
        awaly = dy*(-1);
    }
    else{
        awalx = endex+(dx*(-1));
        awaly = endey+(dy*(-1));
    }
    r.setViewBox(awalx, awaly, r.width, r.height);   
    r.safari();
}
var endex = 0;
var endey = 0;
function grabup() {
    endex = awalx;
    endey = awaly;
    //this.animate({"fill-opacity": 1}, 300);    
    //updatecolor();
}