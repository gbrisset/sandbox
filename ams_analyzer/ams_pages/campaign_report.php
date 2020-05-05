<?php

/*
NEEDS the following improvements

Nothing so far


*/


# ---------------------------------------------------------------
# ---------- CONFIG STUFF ---------------------------------------
# ---------------------------------------------------------------

// $ams_utilities->better_vardump($q_string,1);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump($q_array,2);// 0- green; 1-red; 2-grey; 3-yellow   
// exit();

if(isset($q_array['r']))$row_max = $q_array['r']; else $row_max = 999999999;


# ---------------------------------------------------------------
# -------- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX --------
# ---------------------------------------------------------------


# ---------------------------------------------------------------
# -------- ACTIVE CAMPAIGNS REPORT ------------------------------
# ---------------------------------------------------------------

// Retrieve active campaigns - List
$query_active_campaigns = " SELECT DISTINCT(cr1.cr_campaign_name) FROM " . DB_CAMPAIGN_REPORT_TABLE . " cr1 ";
$query_active_campaigns .= " WHERE cr1.cr_report_date IN (SELECT MAX(cr2.cr_report_date) FROM campaign_reports cr2);";

$params_active_campaigns = []; 

$cr_active_campaigns = $ams_utilities->sql_get_all_rows($query_active_campaigns, $params_active_campaigns);


// $ams_utilities->better_vardump($cr_active_campaigns,2);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump("<br>cr_active_campaigns_report Done ",0);// 0- green; 1-red; 2-grey; 3-yellow   
// exit();

// Retrieve active campaigns - Data
foreach ($cr_active_campaigns as $cac_key => $cac_value) {

	$query_active_campaigns = " SELECT cr_report_date AS crt_date, cr_campaign_name AS crt_name, ";
	$query_active_campaigns .= " cr_campaign_impressions AS crt_impressions, " ;
	$query_active_campaigns .= " cr_campaign_clicks AS crt_clicks, " ;
	$query_active_campaigns .= " cr_campaign_orders AS crt_orders " ;

	$query_active_campaigns .= " FROM " . DB_CAMPAIGN_REPORT_TABLE ;
	$query_active_campaigns .= " WHERE cr_campaign_name = :cr_campaign_name " ;
	$query_active_campaigns .= " ORDER BY cr_report_date DESC " ;

	$params_active_campaigns['cr_campaign_name'] = $cac_value['cr_campaign_name'];

	$cr_active_campaigns_report[] = $ams_utilities->sql_get_all_rows($query_active_campaigns, $params_active_campaigns);

}//end foreach ($kw_harvest_raw as $acr_key => $acr_value)



// $ams_utilities->better_vardump($query_active_campaigns,3);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump($params_active_campaigns,3);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump($cr_active_campaigns_report,2);// 0- green; 1-red; 2-grey; 3-yellow   
// $ams_utilities->better_vardump("<br>cr_active_campaigns_report Done ",0);// 0- green; 1-red; 2-grey; 3-yellow   
// exit();

// Retrieve active campaigns - Display

foreach ($cr_active_campaigns_report as $acr_campaign_key => $acr_campaigns) {

	echo "<table class=\"zx_table\">";

	$acr_display_row =  "<tr class = \"zx_bg_dark_gray zx_text_white\">";
		$acr_display_row .=  "<th class=\"zx_align_center\">Date</th>";
		$acr_display_row .=  "<th class=\"zx_align_left\" style=\"width:30%\">Campaign Name</th>";

		$acr_display_row .=  "<th class=\"zx_align_center\">Impressions</th>";
		$acr_display_row .=  "<th class=\"zx_align_center\">Clicks</th>";
		$acr_display_row .=  "<th class=\"zx_align_center\">Orders</th>";
		
		$acr_display_row .=  "<th class=\"zx_align_center \">+ Imp</th>";
		$acr_display_row .=  "<th class=\"zx_align_center \">+ Clk</th>";
		$acr_display_row .=  "<th class=\"zx_align_center \">+ Ord</th>";

		$acr_display_row .=  "<th class=\"zx_align_center\">Imp/d</th>";
		$acr_display_row .=  "<th class=\"zx_align_center\">Clk/d</th>";
		$acr_display_row .=  "<th class=\"zx_align_center\">Ord/d</th>";
	$acr_display_row .=  "</tr>";

	echo $acr_display_row;

	$row_counter=0;

	$acr_last_ley = count($acr_campaigns)-1;

	foreach ($acr_campaigns as $acr_campaign_row_key => $acr_campaign_row_value) {

			$this_day_date = new DateTime($acr_campaign_row_value['crt_date']);
			$this_day_date_txt = $this_day_date->format('Y-m-d');
			$this_day_name = $acr_campaign_row_value['crt_name'];

			$this_day_imp = $acr_campaign_row_value['crt_impressions'];
			$this_day_clk = $acr_campaign_row_value['crt_clicks'];
			$this_day_ord = $acr_campaign_row_value['crt_orders'];

		if($acr_campaign_row_key < $acr_last_ley){

			$previous_day_date = new DateTime($acr_campaigns[$acr_campaign_row_key + 1]['crt_date']);
			$date_interval = $this_day_date->diff($previous_day_date, true)->days;

			$previous_day_imp = $acr_campaigns[$acr_campaign_row_key + 1]['crt_impressions'];
			$previous_day_clk = $acr_campaigns[$acr_campaign_row_key + 1]['crt_clicks'];
			$previous_day_ord = $acr_campaigns[$acr_campaign_row_key + 1]['crt_orders'];

			$var_imp = $this_day_imp - $previous_day_imp;
			$var_clk = $this_day_clk - $previous_day_clk;
			$var_ord = $this_day_ord - $previous_day_ord;

			$per_day_imp = round($var_imp/$date_interval);
			$per_day_clk = round($var_clk/$date_interval);
			$per_day_ord = round($var_ord/$date_interval);
		
		}else{
		
			$var_imp = 0;
			$var_clk = 0;
			$var_ord = 0;

			$per_day_imp = 0;
			$per_day_clk = 0;
			$per_day_ord = 0;

		}//end if(acr_campaign_key < $acr_last_ley)


		$acr_display_row =  "<tr>";
			$acr_display_row .=  "<td class=\"zx_align_center\">$this_day_date_txt</td>";
			$acr_display_row .=  "<td class=\"zx_align_left\">$this_day_name</td>";

			$acr_display_row .=  "<td class=\"zx_align_center\">$this_day_imp</td>";
			$acr_display_row .=  "<td class=\"zx_align_center\">$this_day_clk</td>";
			$acr_display_row .=  "<td class=\"zx_align_center\">$this_day_ord</td>";

			$acr_display_row .=  "<td class=\"zx_align_center zx_border_left zx_border_red\">$var_imp</td>";
			$acr_display_row .=  "<td class=\"zx_align_center \">$var_clk</td>";
			$acr_display_row .=  "<td class=\"zx_align_center zx_border_right zx_border_red\">$var_ord</td>";

			$acr_display_row .=  "<td class=\"zx_align_center\">$per_day_imp</td>";
			$acr_display_row .=  "<td class=\"zx_align_center\">$per_day_clk</td>";
			$acr_display_row .=  "<td class=\"zx_align_center\">$per_day_ord</td>";
		$acr_display_row .=  "</tr>";

		echo $acr_display_row;

		$row_counter++; if ($row_counter==$row_max) break;

	}//end foreach ($acr_campaigns as $acr_campaign_row_key => $acr_campaign_row_value)
}//end foreach ($cr_active_campaigns_report as $acr_campaign_key => $acr_campaigns) 

echo "</table>";



# ---------------------------------------------------------------
# -------- XXXXXXXXXXXX    NEXT IN BUSINESS LOGIC XXXXXXXXXXXXXXXXXXXXXXXX --------
# ---------------------------------------------------------------



?>

