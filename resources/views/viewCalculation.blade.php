<?php
/*--------------------Start Calculation for High School---------------*/
	   $high_percentage = $results->high_percentage;
	   $high_school_calculation = round(($high_percentage*5)/10);
	   /*--------------------End Calculation for High School-----------------*/
	   
	   /*--------------------Start Calculation for Inter---------------*/
	   $inter_percentage = $results->inter_percentage;
	   $inter_calculation = round(($inter_percentage*3)/10);
	   /*--------------------End Calculation for Inter-----------------*/
	   
/*--------------------Start Calculation for certification (Getting month and Days)-------------*/
	   $training_certificate_period_in_month = $results->training_certificate_period_in_month;
	   $training_certificate_period_in_days = $results->training_certificate_period_in_days;
	   
	   $training_certificate_period_in_month = ($training_certificate_period_in_month)?$training_certificate_period_in_month:0;
	   $training_certificate_period_in_days = ($training_certificate_period_in_days)?$training_certificate_period_in_days:0;
	   
	   $total_number_of_training_days = ($training_certificate_period_in_month*30) + $training_certificate_period_in_days;
	   
	   if($total_number_of_training_days>=1 && $total_number_of_training_days<=30){ //upto 1 month
		   
		   $gettingAnk = 4;
		   
	   } else if($total_number_of_training_days>30 && $total_number_of_training_days<=60){ // 1-2 months
		   
		   $gettingAnk = 8;
		   
	   } else if($total_number_of_training_days>60 && $total_number_of_training_days<=90){ // 2-3 months
		   
		   $gettingAnk = 12;
		   
	   } else if($total_number_of_training_days>90 && $total_number_of_training_days<=120){ // 3-4 months
		   
		   $gettingAnk = 16;
		   
	   } else if($total_number_of_training_days>120){ // more than 4 months
		   
		   $gettingAnk = 20;
		   
	   }else{
		   
		   $gettingAnk = 0;
	   }
	   /*--------------------End Calculation for certification (Getting month and Days)-------------*/
	   
	   /*--------------Getting TOtal Numbers-------------------------*/
	   $topper_number = $high_school_calculation + $inter_calculation + $gettingAnk;
?>


<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>हाई स्कूल (जीव विज्ञान)</th>
            <th>प्राप्तांक ({{$results->high_marks}})</th>
            <th>पूर्णांक ({{$results->high_total_marks}})</th>
            <th>प्रतिशत ({{$results->high_percentage}})</th>
            <th>फार्मूला<br>प्रतिशत * 5/10</th>
            <th style="text-align:right;">स्वतः मूल्यांकन अंक<br>
            <?php echo round(($results->high_percentage*5)/10);?>
            </th>
        </tr>
        
        <tr>
            <th>इण्टर (जीव विज्ञान)</th>
            <th>प्राप्तांक ({{$results->inter_marks}})</th>
            <th>पूर्णांक ({{$results->inter_total_marks}})</th>
            <th>प्रतिशत ({{$results->inter_percentage}})</th>
            <th>फार्मूला<br>प्रतिशत * 3/10</th>
            <th style="text-align:right;">स्वतः मूल्यांकन अंक<br>
            <?php echo round(($results->inter_percentage*3)/10);?>
            </th>
        </tr>
        
        <tr>
            <th>प्रशिक्षण का प्रमाण पत्र</th>
            <th>प्रशिक्षण की अवधि माह ({{$results->training_certificate_period_in_month}})</th>
            <th>दिन ({{$results->training_certificate_period_in_days}})</th>
            <th colspan="3" style="text-align:right;">स्वतः मूल्यांकन अंक<br>
            <?php echo $gettingAnk;?>
            </th>
        </tr>
        
        <tr>
            <th colspan="5" style="text-align:right;">कुल स्वतः मूल्यांकन अंक</th>
            <th style="text-align:right;"><?php echo $topper_number;?>
            </th>
        </tr>
        
        
        
    </thead>
</table>
<strong>नोट : प्रशिक्षण का प्रमाण पत्र का आकलन</strong><br>
एक माह से कम प्रशिक्षण = 4अंक<br>
एक माह से दो माह तक प्रशिक्षण = 8अंक<br>
दो माह से तीन माह तक का प्रशिक्षण = 12अंक<br>
तीन माह से चार माह तक का प्रशिक्षण = 16अंक<br>
चार माह से अधिक का प्रशिक्षण = 20अंक<br>

</div> 

