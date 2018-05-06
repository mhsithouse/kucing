<script type="text/javascript">
    
function OnImageLoad(evt,sq) {



    var img = evt.currentTarget;



    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;

    

    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);



    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft= result.targetleft+"px"

    img.style.marginTop= result.targettop+"px"

   // img.setStyle({left: result.targetleft});

   // img.setStyle({top: result.targettop});

}

function resizeAndJustify(id,sq) {



    var img = document.getElementById(id);



    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;

    

    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);



    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft= result.targetleft+"px"

    img.style.marginTop= result.targettop+"px"

   // img.setStyle({left: result.targetleft});

   // img.setStyle({top: result.targettop});

}



function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {



    var result = { width: 0, height: 0, fScaleToTargetWidth: true };



    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {

        return result;

    }



    // scale to the target width

    var scaleX1 = targetwidth;

    var scaleY1 = (srcheight * targetwidth) / srcwidth;



    // scale to the target height

    var scaleX2 = (srcwidth * targetheight) / srcheight;

    var scaleY2 = targetheight;



    // now figure out which one we should use

    var fScaleOnWidth = (scaleX2 > targetwidth);

    if (fScaleOnWidth) {

        fScaleOnWidth = fLetterBox;

    }

    else {

       fScaleOnWidth = !fLetterBox;

    }



    if (fScaleOnWidth) {

        result.width = Math.floor(scaleX1);

        result.height = Math.floor(scaleY1);

        result.fScaleToTargetWidth = true;

    }

    else {

        result.width = Math.floor(scaleX2);

        result.height = Math.floor(scaleY2);

        result.fScaleToTargetWidth = false;

    }

    result.targetleft = Math.floor((targetwidth - result.width) / 2);

    result.targettop = Math.floor((targetheight - result.height) / 2);



    return result;

}

/*
 * pull content
 */
var w;
var anzahlInbox = 0;
var tstamp = 0;
var updateInbox = [];
var maxInboxID = [];

function pullContent2(){

    if(typeof(Worker) !== "undefined")

    {

      if(typeof(w) == "undefined")

        {

        w = new Worker("<?=_SPPATH;?>webworker.js");

        }
       // w.postMessage({'cmd': 'start', 'maxInboxID': maxInboxID});
        w.onmessage = function (event){

           // var rres = event.data;
            var hasil = JSON.parse(event.data);
            var reload = 0;
            var mengecil = 0;
            console.log(hasil);

            var aa = parseInt(hasil.totalmsg);
            updateInbox = hasil.updateArr;
            var ts = parseInt(hasil.timestamp);
            if(tstamp != ts)reload = 1;
            tstamp = ts;
            
            //cek apakah mengurangi
            if(aa<anzahlInbox)mengecil=1;
            anzahlInbox = aa;
            //$('oktop').fade().fade();
            
            //document.getElementById("content_utama").innerHTML = document.getElementById("content_utama").innerHTML+event.data;
            if(reload){
                lwrefresh("Inbox");
                $('#jmlEnvBaru').html(aa);
                $("#envelopebaloon").html(aa);
                
                if(aa == 0){
                    $("#envelopebaloon").hide();
                }
                else{
                    $("#envelopebaloon").fadeIn();
                }
                if(!mengecil){
                    //update link diatas
                    $('#envelopeul').load('<?=_SPPATH;?>Inboxweb/fillEnvelope');
                    //update window chat..
                    
                    var len = updateInbox.length;
                    for(key=0;key<len;key++){
                        var keyactual = "inboxView"+updateInbox[key];
                        //lwrefresh("inboxView"+updateInbox[key]);
                        
                        // ambil id yang mungkin ada...
                        var len2 = all_lws.length;
                        for(key2=0;key2<len2;key2++){
                            if( keyactual == all_lws[key2].lid){
                                // you got matched, no load needed
                                    $('#chatInbox'+updateInbox[key]).load('<?=_SPPATH;?>Inboxweb/see?all=1&id='+updateInbox[key]);
                                    //all_lws[key].refreshe( all_lws[key].urls,all_lws[key].ani);
                                //return 1;
                            }else{
                                //hide all others
                                //all_lws[key].sendBack();
                            }
                        }
                    }
                    
                }
            }
            

        };

    }

    else

    {
        console.log("Sorry, your browser does not support Web Workers...");
    }
}
/*
* openMuridProfile
 */
 function openProfile(mid){
    openLw('MuridProfle'+mid,'<?=_SPPATH;?>Muridweb/profile?acc_id='+mid,'fade');
 }
</script><?php

/* 
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

