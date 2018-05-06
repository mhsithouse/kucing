<?
    $jml = 0;$total = 0;$small = 100;$big = 0; $num = 1;

    $t = time();

    foreach($arr as $num=>$result)

    {
        $labels[] = $num+1;
        $data[] = $result->nilai_value;
        $total += $result->nilai_value;
        $jml++;
        if($small>$result->nilai_value) $small = $result->nilai_value;
        if($big<$result->nilai_value) $big = $result->nilai_value;
    }



    $rata = round($total/$jml, 1);;

    $imp = implode(",",$labels);

    $impnilai = implode(",",$data); 

// 

//         echo "Rata: " . $rata . "<br>";

//         echo "imp: " . $imp . "<br>";

//         echo "impnilai: " . $impnilai . "<br>";

?>

<style type="text/css">
    .nilainya{ font-size: 10em; text-align: center; width: 100%;}
    .tglnilai,.isinilai, .judulnilai{ float:left; width: 33%;}
    .isinilai{ font-weight: bold;}
    .rightnilai{ padding-bottom: 5px;}
    .judulnilai{text-align: left;}
    .satuannilai{clear: both; margin: 10px; padding: 10px; text-align: center; background-color: #efefef; border-radius: 3px;}
    .clear{clear: both;}

</style>

    

<div style="float:left; width: 320px; ">
    <div class="nilairata">
        <div class="ratalabel"><?=Lang::t('Avg. Grade');?></div>
        <div class="nilainya"><?=$rata;?></div>
                </div>
    </div>

    <div style="float:left; width: 320px;padding-top: 10px;">

        <canvas id="canvas_<?=$t;?>" width="320px" height="200px"></canvas> 

    </div>

    <div class="clear"></div> 

        <div style="float:left; width: 320px;padding-top: 10px;">

        <?
            foreach($arr as $result){?>

            <div class="satuannilai">

                <div class="tglnilai">

                    <?=date("m-d-Y",  strtotime($result->name_nilai_date));?>

                </div>
                <div class="judulnilai">

                    <?=trim($result->name_nilai_judul);?>

                </div>
                <div class="isinilai <?if($result->nilai<60)echo "redgrade";?>">

                        <?=$result->nilai_value;?>

                </div>
                <div class="clear"></div>     

            </div>

        <? } ?>

        </div>  

    

    <div style="float:left; width: 320px;padding-top: 10px; text-align: right;">

        <div class="rightnilai">
            <?=Lang::t('Highest Grade');?> : <b><?=$big;?></b>
        </div>

        <div class="rightnilai">
            <?=  Lang::t('Lowest Grade');?> : <b><?=$small;?></b>

        </div>

        <div class="rightnilai">

            <?=  Lang::t('Total Data');?> : <b><?=$jml;?></b>

        </div>

        <div class="rightnilai">

            <?=  Lang::t('Total Score');?> : <b><?=$total;?></b>

        </div>

    </div>
<!--
<div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Line Chart</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                                </div> /.box-body 
                            </div> /.box -->
                            
                            
                            
    <div class="clear" style="margin-bottom: 200px;"></div>

    <script>
        var scaleSteps = {
            scaleOverride : true,
            scaleStartValue : 0,
            scaleSteps : 10,
            scaleStepWidth : 10
        }
            var lineChartData = {

            labels : [<?=$imp;?>],

            datasets : [{

			fillColor : "rgba(151,187,205,0.5)",

			strokeColor : "rgba(151,187,205,1)",

			pointColor : "rgba(151,187,205,1)",

			pointStrokeColor : "#fff",

			data : [<?=$impnilai;?>]

			}

			]

			

		};

	var myLine = new Chart(document.getElementById("canvas_<?=$t;?>").getContext("2d")).Line(lineChartData, scaleSteps);

// var line = new Morris.Line({
//                    element: 'line-chart',
//                    resize: true,
//                    data: [
//                        {note: 'Semester 1', nilai: 500},
//                        {note: 'Semester 2', nilai: 950}
//                    ],
//                     parseTime: false,
//                    xkey: 'note',
//                    ykeys: ['nilai', 'tanggal'],
//                    labels: ['Semester 1', 'tanggal'],
//                    lineColors: ['#3c8dbc'],
//                    hideHover: 'auto'
//                });

               
	</script>
