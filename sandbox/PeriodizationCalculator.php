<!DOCTYPE html>
<html ng-app>

  <head>
  </head>

  <body>

<!-- 
---------------------------------------------------------------------

PASTE CODE IN 3 LOCATIONS

jAVASCRIPT IN HEADER & FOOTER
CSS IN THEME CUSTOMIZER
HTML/PHP IN POST

---------------------------------------------------------------------
 -->


<!-- BEGINNING OF CODE TO PASTE IN Theme customiser -->


<style type="text/css">


button.pcalc {
    border-radius: 33%;
    width: 50px;
    height: 50px;
    font-size: x-large; 
    cursor: pointer;
}

button.pcalc:focus {outline: none; }

 button#button_dec_current_max{background-color: #c2ff66;}   
 button#button_inc_current_max{background-color: #ffad00;}   
    
table.pcalc {
  border-collapse: collapse;
  width: 80%;
  margin: 0 auto;
}
    

/*tr:nth-child(even) {background-color: #ff9900;} */
tr:nth-child(even).results {background-color: #ffcc00;} 
td.pcalc {text-align: center;}
input.current_max{width: 100%;}


div.w1_pcalc_chart_bar {background-color: #c2ff66; text-align: left;}
div.w2_pcalc_chart_bar {background-color: #ffad00; text-align: left;}
div.w3_pcalc_chart_bar {background-color: #c2ff66; text-align: left;}
div.w4_pcalc_chart_bar {background-color: #ffad00; text-align: left;}


td.w1_pcalc_chart, h2.w1_pcalc_chart {background-color: #c2ff66;}
td.w2_pcalc_chart, h2.w2_pcalc_chart {background-color: #ffad00;}
td.w3_pcalc_chart, h2.w3_pcalc_chart {background-color: #c2ff66;}
td.w4_pcalc_chart, h2.w4_pcalc_chart {background-color: #ffad00;}


</style>
<!-- END OF CODE TO PASTE IN Theme customiser -->

<!-- BEGINNING OF CODE TO PASTE IN WP POST -->



    <h1>Periodization Calculator</h1>
          <h3>Your current maximum</h3>


<!-- Compile in one line before inserting into post -->          
            <button class="pcalc" id="button_dec_current_max" onclick="dec_current_max()">-1</button>
            <button class="pcalc" id="button_inc_current_max" onclick="inc_current_max()">+1</button>
          
          <input id="current_max" value="20" onkeyup="recalculate_all(); recalculate_all_pcalc_charts()" style="width: 50px;     vertical-align: text-bottom;" />
          
             <select style="width: auto; " id="effort_measurement" onchange="recalculate_all_pcalc_charts()">
              <option value="level">Effort Level</option>
              <option value="minutes">Minutes</option>
              <option value="miles">Miles</option>
              <option value="km">Km</option>
              <option value="lbs">Lbs</option>
              <option value="kg">Kg</option>
              <option value="reps">Reps</option>
              <option value="lifts">Lifts</option>
              <option value="laps">Laps</option>
            </select>
<!-- End of Compile in one line before inserting into post -->          
          

    <div>
      <table class="pcalc" cellspacing="4" cellpadding="4">
    <col width="10%">
    <col width="10%">
    <col width="10%">

    <col width="10%" style="    border-right: 1px solid #000;  border-left: 1px solid #000;">
    <col width="10%" style="    border-right: 1px solid #000;">
    <col width="10%" style="    border-right: 1px solid #000;">
    <col width="10%" style="    border-right: 1px solid #000;">

        <tr>
          <td colspan="3">&nbsp;</td>
          <td class="pcalc w1_pcalc_chart"><b>Week 1</b></td>
          <td class="pcalc w2_pcalc_chart"><b>Week 2</b></td>
          <td class="pcalc w3_pcalc_chart"><b>Week 3</b></td>
          <td class="pcalc w4_pcalc_chart"><b>Week 4</b></td>
        </tr>
<!-- Weekly effort - select -->
        <tr>

          <td class="pcalc" colspan="3">&nbsp;</td>
          <td class="pcalc">
            <select style="width: auto; " id="w1_effort" onchange="recalculate('w', 1); recalculate_all_pcalc_chart()" >
              <option value="0.6" selected="selected">Easy</option>
              <option value="0.8">Medium</option>
              <option value="1.2">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc">
            <select style="width: auto; " id="w2_effort" onchange="recalculate('w', 2); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8" selected="selected">Medium</option>
              <option value="1.2">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc">
            <select style="width: auto; " id="w3_effort" onchange="recalculate('w', 3); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>
              <option value="1.2" selected="selected">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc">
            <select style="width: auto; " id="w4_effort" onchange="recalculate('w', 4); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>
              <option value="1.2">Hard</option>
              <option value="0.2" selected="selected">Recovery</option>
            </select>
          </td>
        </tr>
<!-- Weekly effort - display -->
        <tr>
          <td class="pcalc">&nbsp;</td>
          <td class="pcalc">&nbsp;</td>
          <td class="pcalc">&nbsp;</td>
          <td class="pcalc" id="w1_display">60%</td>
          <td class="pcalc" id="w2_display">80%</td>
          <td class="pcalc" id="w3_display">120%</td>
          <td class="pcalc" id="w4_display">40%</td>
        </tr>

<!-- Monday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Monday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d1_effort" onchange="recalculate('d',1); recalculate_all_pcalc_chart()" >
              <option value="0.6" selected="selected">Easy</option>
              <option value="0.8">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d1_display">60%</td>
          <td class="pcalc" id="d1w1_result">0</td>
          <td class="pcalc" id="d1w2_result">0</td>
          <td class="pcalc" id="d1w3_result">0</td>
          <td class="pcalc" id="d1w4_result">0</td>
        </tr>


<!-- Tuesday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Tuesday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d2_effort" onchange="recalculate('d',2); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8" selected="selected">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d2_display">80%</td>
          <td class="pcalc" id="d2w1_result">0</td>
          <td class="pcalc" id="d2w2_result">0</td>
          <td class="pcalc" id="d2w3_result">0</td>
          <td class="pcalc" id="d2w4_result">0</td>
        </tr>


<!-- Wednesday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Wednesday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d3_effort" onchange="recalculate('d',3); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2" selected="selected">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d3_display">40%</td>
          <td class="pcalc" id="d3w1_result">0</td>
          <td class="pcalc" id="d3w2_result">0</td>
          <td class="pcalc" id="d3w3_result">0</td>
          <td class="pcalc" id="d3w4_result">0</td>
        </tr>


<!-- Thursday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Thursday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d4_effort" onchange="recalculate('d',4); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8" selected="selected">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d4_display">80%</td>
          <td class="pcalc" id="d4w1_result">0</td>
          <td class="pcalc" id="d4w2_result">0</td>
          <td class="pcalc" id="d4w3_result">0</td>
          <td class="pcalc" id="d4w4_result">0</td>
        </tr>


<!-- Friday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Friday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d5_effort" onchange="recalculate('d',5); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>''
              <option value="1.2" selected="selected">Hard</option>
              <option value="0.2">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d5_display">120%</td>
          <td class="pcalc" id="d5w1_result">0</td>
          <td class="pcalc" id="d5w2_result">0</td>
          <td class="pcalc" id="d5w3_result">0</td>
          <td class="pcalc" id="d5w4_result">0</td>
        </tr>


<!-- Saturday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Saturday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d6_effort" onchange="recalculate('d',6); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2" selected="selected">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d6_display">40%</td>
          <td class="pcalc" id="d6w1_result">0</td>
          <td class="pcalc" id="d6w2_result">0</td>
          <td class="pcalc" id="d6w3_result">0</td>
          <td class="pcalc" id="d6w4_result">0</td>
        </tr>



<!-- Sunday select effort and result -->
        <tr class="results">
          <td class="pcalc"><b>Sunday</b></td>
          <td class="pcalc">
            <select style="width: auto; " id="d7_effort" onchange="recalculate('d',7); recalculate_all_pcalc_chart()" >
              <option value="0.6">Easy</option>
              <option value="0.8">Medium</option>''
              <option value="1.2">Hard</option>
              <option value="0.2" selected="selected">Recovery</option>
            </select>
          </td>
          <td class="pcalc" id="d7_display">40%</td>
          <td class="pcalc" id="d7w1_result">0</td>
          <td class="pcalc" id="d7w2_result">0</td>
          <td class="pcalc" id="d7w3_result">0</td>
          <td class="pcalc" id="d7w4_result">0</td>
        </tr>

</table >
</div>

<h2>Weekly Charts</h2>
<div>
<table class="pcalc" cellspacing="4" cellpadding="4">
		<col width="10%">
		<col width="10%">
    <col width="10%">
		<col width="10%">
		<col width="*">

<?php 

$weekdays = array(1 => "Monday" , 2 => "Tuesday" , 3 => "Wednesday" , 4 => "Thursday" , 5 => "Friday" , 6 => "Saturday" , 7 => "Sunday"  );

              for ( $w = 1; $w <= 4; $w++) {

                echo"<tr><td colspan=\"4\" style=\"text-align:left;\" ><H2 class=\"w$w"."_pcalc_chart\">Week $w</H2></td></tr>";

                for ( $d = 1; $d <= 7; $d++) {
                    echo"

                            <tr style=\"border-bottom: 1px solid #000;\">
                              <td class=\"pcalc\" ><b>$weekdays[$d]</b></td>
                              <td class=\"pcalc\"  id=\"d$d"."w$w"."_pcalc_chart_effort\">Effort</td>
                              <td class=\"pcalc\"  id=\"d$d"."w$w"."_pcalc_chart_percent\">Percent</td>
                              <td class=\"pcalc\"  id=\"d$d"."w$w"."_pcalc_chart_effort_measurement\">Measure</td>
                              <td class=\"pcalc\"  ><div id=\"d$d"."w$w"."_pcalc_chart_bar\" class=\"w$w"."_pcalc_chart_bar\" style=\"width: 50%\">&nbsp;</div></td>
                            </tr>

                    ";


                }//end for d
              }//end for w

?>




</table>
</div>



<!-- END OF CODE TO PAST IN WP POST -->


<!-- BEGINNING OF CODE TO PAST IN HEADER & FOOTER -->

  
    <script language="javascript">

        
        //GENERIC FUNCTIONS

        function gebi(el){  return document.getElementById(el);}

        function format_percent(the_number){
            var n= new Number(the_number);
            n = n.toFixed(0)+"%";
            return n;
        }//end function



        //CALCULATOR CODE
        

    function get_current_max(){
          obj_current_max = gebi("current_max");//original value is 20 in HTML
          return obj_current_max.value;
    }//end function

        
        function inc_current_max() {
          var_current_max = get_current_max();
          obj_current_max.value = (var_current_max)-0 + 1; 
          recalculate_all()
          recalculate_all_pcalc_charts()
        }//end function

        function dec_current_max() {
          var_current_max = get_current_max();
          a = (var_current_max)-0 - 1; 
          if (a <1){a=1} 
          obj_current_max.value = a;
          recalculate_all()
          recalculate_all_pcalc_charts()
        }//end function


        function recalculate(var_period, var_number) {
      var_current_max = get_current_max();
            //Set the percent effort
            obj_percent = gebi(var_period+var_number+"_effort");
            obj_temp = gebi(var_period+var_number+"_display");
            obj_temp.innerHTML = format_percent(obj_percent.value * 100);

            // recalculate the row for the corresponding day
            if(var_period=='d'){
              for (var w = 1; w <= 4; w++) {
                var_w_percent = gebi("w"+w+"_effort").value;
                gebi("d"+var_number+"w"+w+"_result").innerHTML = 2*Math.trunc((1+var_current_max * var_w_percent * obj_percent.value)/2);//rounding up to the nearest even number
              }//end for 
            }//end if day

            // recalculate the column for the corresponding week
            if(var_period=='w'){
              for (var d = 1; d <= 7; d++) {
                var_d_percent = gebi("d"+d+"_effort").value;
                gebi("d"+d+"w"+var_number+"_result").innerHTML = 2*Math.trunc(1+(var_current_max * var_d_percent * obj_percent.value)/2);//rounding up to the nearest even number
              }//end for 
            }//end if week

        }//end function recalculate


        function recalculate_all() {
          var_current_max = get_current_max();

            // recalculate each cell
              for (var w = 1; w <= 4; w++) {
                    var_w_percent = gebi("w"+w+"_effort").value;
                for (var d = 1; d <= 7; d++) {
                    var_d_percent = gebi("d"+d+"_effort").value;
                    gebi("d"+d+"w"+w+"_result").innerHTML = 2*Math.trunc(1+(var_current_max * var_d_percent * var_w_percent)/2);//rounding up to the nearest even number
                }//end for d
              }//end for w
    
        }//end function recalculate_all


        function recalculate_all_pcalc_charts() {
          var_current_max = get_current_max();
          var_hard_max = var_current_max * 1.2 * 1.2;

            // recalculate each cell
              for (var w = 1; w <= 4; w++) {
                    var_w_percent = gebi("w"+w+"_effort").value;
                for (var d = 1; d <= 7; d++) {
                    obj_d_effort = gebi("d"+d+"_effort");
                    var_d_percent = obj_d_effort.value;
                    var_d_effort_text = obj_d_effort.options[obj_d_effort.selectedIndex].text;
                    var_d_display = gebi("d"+d+"_display").innerHTML;

                      // console.log(var_d_effort_text);



                     var_pcalc_chart_bar = 2*Math.trunc(1+(var_current_max * var_d_percent * var_w_percent)/2);//rounding up to the nearest even number
                     var_pcalc_chart_bar_width = format_percent( Math.trunc((var_pcalc_chart_bar/var_hard_max)*100));

                    gebi("d"+d+"w"+w+"_pcalc_chart_effort").innerHTML = var_d_effort_text;
                    gebi("d"+d+"w"+w+"_pcalc_chart_percent").innerHTML = var_d_display;
                    gebi("d"+d+"w"+w+"_pcalc_chart_effort_measurement").innerHTML = gebi("effort_measurement").value;

                    gebi("d"+d+"w"+w+"_pcalc_chart_bar").setAttribute('style', '');
                    gebi("d"+d+"w"+w+"_pcalc_chart_bar").setAttribute('style', 'width: ' + var_pcalc_chart_bar_width);
                    gebi("d"+d+"w"+w+"_pcalc_chart_bar").innerHTML =    var_pcalc_chart_bar;
                    // gebi("d"+d+"w"+w+"_pcalc_chart_bar").innerHTML =   + ": " +  var_pcalc_chart_bar;




                }//end for d
              }//end for w
    
        }//end function recalculate_all


// Reset 
recalculate('w', 1);
recalculate('w', 2);
recalculate('w', 3);
recalculate('w', 4);

recalculate('d', 1);
recalculate('d', 2);
recalculate('d', 3);
recalculate('d', 4);
recalculate('d', 5);
recalculate('d', 6);
recalculate('d', 7);

recalculate_all();

recalculate_all_pcalc_charts();



// var a  = 33.1;
// var b = 2*Math.trunc((a+1)/2);


    </script>

<!-- END OF CODE TO PAST IN HEADER & FOOTER -->



  </body>

</html>
