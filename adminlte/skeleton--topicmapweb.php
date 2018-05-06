<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
<title><?=$title;?></title>
 <?=$metaKey;?>
 <?=$metaDescription;?>

<? //$this->getHeadfiles();?>
<style type="text/css">
body{ 
    margin: 0; 
    padding: 0;
    font-family:verdana;
    font-size:13px;
}
body {
    

    background: rgb(215, 215, 215);
    background: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 500, from(rgb(240, 240, 240)), to(rgb(190, 190, 190)));
    background: -webkit-radial-gradient(rgb(240, 240, 240), rgb(190, 190, 190));
    background:    -moz-radial-gradient(rgb(240, 240, 240), rgb(190, 190, 190));
    background:     -ms-radial-gradient(rgb(240, 240, 240), rgb(190, 190, 190));
    background:      -o-radial-gradient(rgb(240, 240, 240), rgb(190, 190, 190));
    background:         radial-gradient(rgb(240, 240, 240), rgb(190, 190, 190));
}
body, html {
  height: 100%; width: 100%;
}
#ribbon{
background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiPgogICAgICAgICAgICA8cmVjdCB4PSIwIiB3aWR0aD0iNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMTcyMzI3Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjciIHdpZHRoPSIxMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMTkzNzJjIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjE5IiB3aWR0aD0iMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMzI3MzQ0Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIxIiB3aWR0aD0iMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojNDM3ZTRjIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIzIiB3aWR0aD0iMTMiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6Izg2OTk1NiIvPgogICAgICAgICAgICA8cmVjdCB4PSIzNiIgd2lkdGg9IjE1IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiNiMDhmNDIiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNTEiIHdpZHRoPSI0OSIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojYjQ2ODM5Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjEwMCIgd2lkdGg9IjI3IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiNhNDM5NDEiLz4KICAgICAgICAgICAgPHJlY3QgeD0iMTI3IiB3aWR0aD0iMTYiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzljMmM1MiIvPgogICAgICAgICAgICA8cmVjdCB4PSIxNDMiIHdpZHRoPSI3MCIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojYmI0MjZiIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIxMyIgd2lkdGg9IjEiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzhhMmY1YyIvPgogICAgICAgICAgICA8cmVjdCB4PSIyMTQiIHdpZHRoPSIyNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojNmQ0MTZkIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjI0MSIgd2lkdGg9IjQzIiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiM0MTMyNjQiLz4KICAgICAgICAgICAgPHJlY3QgeD0iMjg0IiB3aWR0aD0iNjEiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzI5NDE2ZSIvPgogICAgICAgICAgICA8cmVjdCB4PSIzNDUiIHdpZHRoPSIxMDUiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzU2OTBhNSIvPgogICAgICAgICAgICA8cmVjdCB4PSI0NTAiIHdpZHRoPSIyIiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiMyZTg0OWQiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNDUyIiB3aWR0aD0iNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMjc2Njg2Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjQ1OSIgd2lkdGg9IjI1IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiMyMzQzNmUiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNDg0IiB3aWR0aD0iMTYiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzE0MmEwNiIvPgogICAgPC9zdmc+Cg==) repeat-x top left;
display: block;
width: 100%;
height: 5px;
}
.rainbow{
background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiPgogICAgICAgICAgICA8cmVjdCB4PSIwIiB3aWR0aD0iNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMTcyMzI3Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjciIHdpZHRoPSIxMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMTkzNzJjIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjE5IiB3aWR0aD0iMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMzI3MzQ0Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIxIiB3aWR0aD0iMiIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojNDM3ZTRjIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIzIiB3aWR0aD0iMTMiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6Izg2OTk1NiIvPgogICAgICAgICAgICA8cmVjdCB4PSIzNiIgd2lkdGg9IjE1IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiNiMDhmNDIiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNTEiIHdpZHRoPSI0OSIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojYjQ2ODM5Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjEwMCIgd2lkdGg9IjI3IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiNhNDM5NDEiLz4KICAgICAgICAgICAgPHJlY3QgeD0iMTI3IiB3aWR0aD0iMTYiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzljMmM1MiIvPgogICAgICAgICAgICA8cmVjdCB4PSIxNDMiIHdpZHRoPSI3MCIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojYmI0MjZiIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjIxMyIgd2lkdGg9IjEiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzhhMmY1YyIvPgogICAgICAgICAgICA8cmVjdCB4PSIyMTQiIHdpZHRoPSIyNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojNmQ0MTZkIi8+CiAgICAgICAgICAgIDxyZWN0IHg9IjI0MSIgd2lkdGg9IjQzIiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiM0MTMyNjQiLz4KICAgICAgICAgICAgPHJlY3QgeD0iMjg0IiB3aWR0aD0iNjEiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzI5NDE2ZSIvPgogICAgICAgICAgICA8cmVjdCB4PSIzNDUiIHdpZHRoPSIxMDUiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzU2OTBhNSIvPgogICAgICAgICAgICA8cmVjdCB4PSI0NTAiIHdpZHRoPSIyIiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiMyZTg0OWQiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNDUyIiB3aWR0aD0iNyIgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbDojMjc2Njg2Ii8+CiAgICAgICAgICAgIDxyZWN0IHg9IjQ1OSIgd2lkdGg9IjI1IiBoZWlnaHQ9IjEwMCUiIHN0eWxlPSJmaWxsOiMyMzQzNmUiLz4KICAgICAgICAgICAgPHJlY3QgeD0iNDg0IiB3aWR0aD0iMTYiIGhlaWdodD0iMTAwJSIgc3R5bGU9ImZpbGw6IzE0MmEwNiIvPgogICAgPC9zdmc+Cg==) repeat-x top left;
}

</style>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/rightjs-all/javascripts/right.js">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/viel-windows.js">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/raphael.js?t=<?=time();?>">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/raphael.pan-zoom.js?t=<?=time();?>">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/leap-topicmap.js?t=<?=time();?>">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/hammer.min.js">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/rightjs-all/javascripts/right/slider.js">
</script>

<script type="text/javascript" src="<?=_SPPATH;?>topicmaptheme/js/rightjs-all/javascripts/right/dialog.js">
</script>

</head>

<body >


<div class="content" id="content_utama">    
<?=$content;?>
</div>

</body>
</html>