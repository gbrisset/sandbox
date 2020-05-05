<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 2048 Game</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style type="text/css">
  .cell-nb{
      text-align: center;
      vertical-align: middle!important;
      background-color: #CCCCCC;
      font-size: 4em;
      font-weight: bold;
      height: 100px;
      width: 100px;
 }
 .cell-click-hrzn{height: 50px; text-align: center; }
 .cell-click-vert{width: 41px; vertical-align: middle; }

</style>

</head>
<body>
<!-- ## DEBUB DIV  ## DEBUB DIV  ## DEBUB DIV  ## DEBUB DIV  ## DEBUB DIV -->
<div style="background-color: #999900; padding:20px; margin:20px">

<?php

#$cells[row#][col#] = 0;

#Top row
$cells[1][1] = 11;
$cells[1][2] = 12;
$cells[1][3] = 13;
$cells[1][4] = 14;

#2nd row
$cells[2][1] = 21;
$cells[2][2] = 22;
$cells[2][3] = 23;
$cells[2][4] = 24;

#Third row
$cells[3][1] = 31;
$cells[3][2] = 32;
$cells[3][3] = 33;
$cells[3][4] = 34;

#Bottom row
$cells[4][1] = 41;
$cells[4][2] = 42;
$cells[4][3] = 43;
$cells[4][4] = 44;


#Push to the right
for ($c=3;$c>0;$c--){
  for ($r=3;$r>0;$r--){


$current_cell = $cells[$r][$c];
$adjacent_cell = $cells[$r+1][$c];
    echo "<br/>\$current_cell r:$r - c:$c - $current_cell" ;
    echo " -- \$adjacent_cell r:$r+1 - c:$c - $adjacent_cell";


  }//for ($r=3;$r>0;$r--)
}//for ($c=3;$c>0;$c--)


?>

  

</div>
<!-- ## END OF DEBUB DIV  ## END OF DEBUB DIV  ## END OF DEBUB DIV  ## END OF DEBUB DIV  ## END OF DEBUB DIV -->

<div class="jumbotron text-center">
  <h1>Bootstrap 2048 Game</h1>
  <p>Click or tap on the sides to slide numbers</p> 
  <p></p> 
</div>

<div class="container" style="width: 530px;">
  

  <table class="table table-bordered ">
    <tbody>
      <tr>
        <td >&nbsp;</td>
        <td id="click-top" class="cell-click-hrzn" colspan="4">CLICK</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td id="click-left" class="cell-click-vert " rowspan="4">CLICK</td>
        <td id="1-1" class="cell-nb "><?php echo $cells[1][1]; ?></td>
        <td id="1-2" class="cell-nb "><?php echo $cells[1][2]; ?></td>
        <td id="1-3" class="cell-nb "><?php echo $cells[1][3]; ?></td>
        <td id="1-4" class="cell-nb "><?php echo $cells[1][4]; ?></td>
        <td id="click-right" class="cell-click-vert " rowspan="4">CLICK</td>
      </tr>
        <td id="2-1" class="cell-nb "><?php echo $cells[2][1]; ?></td>
        <td id="2-2" class="cell-nb "><?php echo $cells[2][2]; ?></td>
        <td id="2-3" class="cell-nb "><?php echo $cells[2][3]; ?></td>
        <td id="2-4" class="cell-nb "><?php echo $cells[2][4]; ?></td>
      </tr>
        <td id="3-1" class="cell-nb "><?php echo $cells[3][1]; ?></td>
        <td id="3-2" class="cell-nb "><?php echo $cells[3][2]; ?></td>
        <td id="3-3" class="cell-nb "><?php echo $cells[3][3]; ?></td>
        <td id="3-4" class="cell-nb "><?php echo $cells[3][4]; ?></td>
      </tr>
        <td id="4-1" class="cell-nb "><?php echo $cells[4][1]; ?></td>
        <td id="4-2" class="cell-nb "><?php echo $cells[4][2]; ?></td>
        <td id="4-3" class="cell-nb "><?php echo $cells[4][3]; ?></td>
        <td id="4-4" class="cell-nb "><?php echo $cells[4][4]; ?></td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td id="click-top" class="cell-click-hrzn" colspan="4">CLICK</td>
        <td >&nbsp;</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
