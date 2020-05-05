<?php

/*
NEEDS the following improvements

Nothing so far


*/

# ---------------------------------------------------------------
# ---------- NOTE ON BUSINESS LOGIC -----------------------------
# ---------------------------------------------------------------
			// As of 2020-04-08  Keywords and ASIN/Categories campaigns have the same filenames but different column structures
			/*
			
			Keyword files: 
			1-State	2-Keyword					3-Match type	4-Status [...]
			
			asin_cat files:
			1-State	2-Categories & products	3-Status [...]

			which offset the rest of the columns

			THE CODE BELOW WORKS ONLY FOR KEYWORDS FILES AS OF 2020-04-10 - GB

			 */




# ---------------------------------------------------------------
# ---------- CONFIG STUFF ---------------------------------------
# ---------------------------------------------------------------


# ----- Regex Patterns ------------------------------------------
$sql_upload_filename_patterns = "/\.csv$/i";
$sql_upload_date_pattern = "/[a-z]{3}_\d{1,2}_\d{4}|\d{4}-\d{2}-\d{2}/i";// AMS report format | Rocket search format
$sql_upload_name_patterns['manual_ams_kw_search'] = "/manual_ams_kw_search/i";
$sql_upload_name_patterns['rocket_ams_kw_search'] = "/AMS Keyword Search/i";
$sql_upload_name_patterns['campaigns'] = "/Campaigns/i";
$sql_upload_name_patterns['keywords'] = "/Sponsored_Products_adgroup_targeting/i";// same pattern as of 2020-04-09 - Two patterns are set for future compatibility
// $sql_upload_name_patterns['asin_cat'] = "/Sponsored_Products_adgroup_targeting/i";// same pattern as of 2020-04-09 - Two patterns are set for future compatibility


# ----- Review list Color classes  ------------------------------------------
$msg_color_classes[1] = "zx_bg_alert_green";
$msg_color_classes[0] = "zx_bg_alert_red";

# ----- Review list Codes  ------------------------------------------
$uf_codes['succ'] = [0=>'Upload failed', 1=>'Upload complete',];
$uf_codes['dupl'] = [0=>'Duplicate data', 1=>'New data inserted',];
$uf_codes['file'] = [0=>'Not a CSV file', 1=>'CSV file type',];
$uf_codes['date'] = [0=>'Undetermined date format in filename', 1=>'Recognized date format in filename',];
$uf_codes['type'] = [0=>'Unknown AMS file type', 1=>'Identified AMS file type',];
$uf_codes['camp'] = [0=>'Undefined campaign name', 1=>'Campaign name OK',]; // only used for Keyword reports

# ---------------------------------------------------------------
# ---------- CSV to SQL -----------------------------------------
# ---------------------------------------------------------------

if(isset($_POST['submit'])) {

    $ams_csv_upload_paths = $_FILES['ams_csv_upload']['tmp_name'];
    $ams_csv_upload_names = $_FILES['ams_csv_upload']['name'];

	
	# ----- Looping through the uploaded CSV files ------------------------------------------
	foreach ($ams_csv_upload_names as $ams_csv_filename_key => $ams_csv_filename_value) {

		$file_check = false;
		$file_success = 0;

		$upload_dupl_check = 0;// Duplicate data is tested individually at the file processing level
		$upload_file_check = 0;
		$upload_date_check = 0;
		$upload_type_check = 0;
		$campaign_name_check = 0;//only used for Keyword reports

		$sql_upload_date = "";
		$sql_upload_type = "invalid";


		#File type must be CSV
		$upload_file_check = preg_match ($sql_upload_filename_patterns, $ams_csv_filename_value);

		# Report Date
		$upload_date_check = preg_match ($sql_upload_date_pattern, $ams_csv_filename_value,$ams_csv_upload_date);
		if ($upload_date_check == 1){
			$sql_upload_date = str_replace("_"," ",$ams_csv_upload_date[0]);
			$sql_upload_date = date("Y-m-d", strtotime($sql_upload_date));
		}//end if

		# Report Type
		foreach ($sql_upload_name_patterns as $pattern_key => $pattern_value) {
			$upload_type_check = preg_match ($pattern_value, $ams_csv_filename_value);
			if($upload_type_check==1) { $sql_upload_type = $pattern_key; break;}// end if
		}//end foreach

		
		$file_check = $upload_file_check + $upload_date_check + $upload_type_check;

		if($file_check==3){

			# Get CSV data
			$csv_data = fopen($ams_csv_upload_paths[$ams_csv_filename_key],"r");
			
			//(re)initialize variable
			$xx=0;
			$csv_data_one_line = array();
			$csv_data_all_lines = array();
			
			// Create php array out of csv data
			// --------------------------------------------------------------------------------
			while(! feof($csv_data)){
				$csv_data_one_line = fgetcsv($csv_data);
				$csv_data_all_lines[] = $csv_data_one_line;
			}//end while(! feof($csv_data))

			// ASIN Campaign detection (asin=15; kw=16; campaigns=18)
			if(count($csv_data_all_lines[0])==15)$sql_upload_type="asin_cat"; 
			
			// Delete First row - it contains headers
			unset($csv_data_all_lines[0]);

			// --------------------------------------------------------------------------------

			switch ($sql_upload_type) {

			// ---------------------------------------------------------------------------------
			// -------- UPDATE DATABASE - KEYWORDS TABLE ---------------------------------------
			// ---------------------------------------------------------------------------------
			
			 	case 'keywords':

				// -------- Extract Campaign name if available ----------------------------------------------
				$kw_prefix = 'zzzzz'; // Campaigns have a dummy keyword containing the campaign name (csv files have all the same generic names regardless of the campaign)
				$sql_campaign_name = "No Campaign Name found if file";// default value
				
				foreach ($csv_data_all_lines as $csv_key => $csv_value) {
					if(preg_match("/\b$kw_prefix\b/i", $csv_value[1])>0){
						$sql_campaign_name = substr($csv_data_all_lines[$csv_key][1], strlen($kw_prefix)+1); // Extract campaign name from dummy keyword
						$campaign_name_check = 1;
						break;
					}//end if
				}//end foreach 

				// -------- Check KW table for duplicates ---------------------------------------------------
				$query_uf = " SELECT  * FROM " . DB_KEYWORD_REPORTS_TABLE . " WHERE kr_campaign_name = :kr_campaign_name AND kr_report_date = :kr_report_date ";
				$params_uf['kr_campaign_name'] = $sql_campaign_name; 
				$params_uf['kr_report_date'] = $sql_upload_date; 
				$file_already_uploaded = $ams_utilities->sql_get_one_row($query_uf, $params_uf);
				if($file_already_uploaded) $upload_dupl_check=0; else $upload_dupl_check = 1; 

				$ams_utilities->better_vardump($csv_data_all_lines,1); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 

				// -------- UPDATE KW TABLE --------------------------------------------------------
				if($upload_dupl_check==1 && $campaign_name_check == 1){
					unset($csv_data_all_lines[$csv_key]);// this kw is useless in the report
					// $csv_data_all_lines = array_values($csv_data_all_lines); DELETE ME

					foreach ($csv_data_all_lines as $csv_key => $csv_value) {
					
						// -------- 1 - Keyword report query ---------------------------------------------------

						$query_kr = " INSERT INTO  " . DB_KEYWORD_REPORTS_TABLE . " (kr_report_date, kr_campaign_name, ";
						$query_kr .= implode(", ",$kr_datafields);
						$query_kr .=")VALUES(:kr_report_date, :kr_campaign_name, ";
						foreach ($kr_datafields as $krd_key => $krd_value) {$query_kr .= ":$krd_value, "; }//end foreach
						$query_kr = substr_replace($query_kr, ");", -2);
						
						// -------- 2 - Keyword report params ---------------------------------------------------

						$params_kr['kr_report_date'] = $sql_upload_date; 
						$params_kr['kr_campaign_name'] = $sql_campaign_name; 

						foreach ($kr_datafields as $krd_key => $krd_value) {
							$params_kr[$krd_value] = $csv_data_all_lines[$csv_key][$krd_key];
						}//end foreach
					
$meta_params_kr[] = $params_kr;//// TEST // TEST // TEST // TEST // TEST // TEST // TEST // TEST // TEST // TEST // TEST 
						// -------- 3 - PDO Execution ---------------------------------------------------------
										
						// $ams_utilities->sql_execute($query_kr, $params_kr);

					}//end foreach ($csv_data_all_lines as $csv_key => $csv_value)


				$ams_utilities->better_vardump($csv_data_all_lines,2); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
				// $ams_utilities->better_vardump($meta_params_kr,3); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
				exit();// EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV 

					$file_success = 1;

				}// end if($upload_dupl_check==1 && $campaign_name_check == 1)

		 		break;

			 	
			// ---------------------------------------------------------------------------------
			// -------- UPDATE DATABASE - ASIN CAMPAIGNS  --------------------------------------
			// ---------------------------------------------------------------------------------
			 	case 'asin_cat':

				// $ams_utilities->better_vardump("ASIN Campaign cannot be processed As of 2020-04-10",3);  //TEST  //TEST  //TEST  //TEST  //TEST 
				// As of 2020-04-10 ASIN campaigns cannot contains the zzzzz dummy keyword - their treatment is omitted until Georges gets a genius idea.
				$file_success = 0; // redondant - just to stay consistent with the idea that each 'case:' is updating the $file_success flag


			 	break;

			// ---------------------------------------------------------------------------------
			// -------- UPDATE DATABASE - CAMPAIGNS TABLE ---------------------------------------
			// ---------------------------------------------------------------------------------
			 	case 'campaigns':

				// -------- Check CR table for duplicate reports ----------------------------------------------
				$query_uf = " SELECT  * FROM " . DB_CAMPAIGN_REPORT_TABLE . " WHERE cr_report_date = :cr_report_date ";
				$params_uf['cr_report_date'] = $sql_upload_date; 
				$file_already_uploaded = $ams_utilities->sql_get_one_row($query_uf, $params_uf);
				if($file_already_uploaded) $upload_dupl_check=0; else $upload_dupl_check = 1; // REVISE WHAT TO DO WITH THAT INFORMATION

// $ams_utilities->better_vardump($upload_dupl_check,3); exit();//VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
				if($upload_dupl_check==1){

					foreach ($csv_data_all_lines as $csv_key => $csv_value) {
					
						// -------- 1 - Campaign report query ---------------------------------------------------

						$query_cr = " INSERT INTO  " . DB_CAMPAIGN_REPORT_TABLE . " (cr_report_date, ";
						$query_cr .= implode(", ",$cr_datafields);
						$query_cr .=")VALUES(:cr_report_date, ";
						foreach ($cr_datafields as $key => $value) {$query_cr .= ":$value, "; }//end foreach
						$query_cr = substr_replace($query_cr, ");", -2);
						
						// -------- 2 - Campaign report params ---------------------------------------------------

						$params_cr['cr_report_date'] = $sql_upload_date; 

						foreach ($cr_datafields as $key => $value) {
							$params_cr[$value] = $csv_data_all_lines[$csv_key][$key];
						}//end foreach
					
						// -------- 3 - PDO Execution ---------------------------------------------------------
						$ams_utilities->sql_execute($query_cr, $params_cr);
					}//end foreach ($csv_data_all_lines as $csv_key => $csv_value)

					$file_success = 1;
		
				}// end if($upload_dupl_check==1)

				break;

			// ---------------------------------------------------------------------------------
			// -------- UPDATE DATABASE - KW HARVEST TABLE -------------------------------------
			// ---------------------------------------------------------------------------------
			 	case 'manual_ams_kw_search':
			 	case 'rocket_ams_kw_search':

				foreach ($csv_data_all_lines as $csv_key => $csv_value) {
				
					// -------- 1 - kw_harvest report query ---------------------------------------------------

					$query_kh = " INSERT INTO  " . DB_KEYWORD_HARVEST_TABLE . " (kh_keyword_text, kh_keyword_author ";
					$query_kh .=")VALUES(:kh_keyword_text, :kh_keyword_author );  ";
					
					// -------- 2 - kw_harvest report params ---------------------------------------------------

					$params_kh['kh_keyword_text'] = $csv_data_all_lines[$csv_key][0]; 
					$params_kh['kh_keyword_author'] = $csv_data_all_lines[$csv_key][1]; 

				// $ams_utilities->better_vardump($query_kh,2); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
				// $ams_utilities->better_vardump($params_kh,2); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
				// exit();// EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV // EXIT DEV 


					// -------- 3 - PDO Execution ---------------------------------------------------------
					$ams_utilities->sql_execute($query_kh, $params_kh);
					
				}//end foreach ($csv_data_all_lines as $csv_key => $csv_value)

				$file_success = 1;

				break;

				default:

				// $ams_utilities->better_vardump("<br>File type UNKNOWN: $ams_csv_filename_key => $ams_csv_filename_value",3); 

				// Nothing should ever happen here
				$file_success = 0; // redondant - just to stay consistent with the idea that each 'case:' is updating the $file_success flag


			}//end switch ($sql_upload_type)


			fclose($csv_data);

		}else{

			//do nothing -- this section had some use in the past that has been emptied out - to be deleted one day - GB 2020-05-01

		}//end if($file_check==3)

			
			if($file_success){

				// -- Record file upload upon success ----
				$query_ufi = " INSERT INTO  " . DB_UPLOADED_FILES_TABLE . " (uf_upload_date, uf_filename)VALUES(:uf_upload_date, :uf_filename) ";
				$params_ufi['uf_filename'] = $ams_csv_filename_value; 
				$params_ufi['uf_upload_date'] = $sql_upload_date; 
						
				$ams_utilities->sql_execute($query_ufi, $params_ufi); 

				// This information is no longer used but logging uploaded files sounds like a good practice - you will thnak me one day... GB 2020-05-01

			}// end if($file_success)

		// Create report for that upload
		$uf_report_id = md5(microtime());// duplicate-free random number!
		$uf_report[$uf_report_id]['filename'] = $ams_csv_filename_value;
		$uf_report[$uf_report_id]['sql_upload_type'] = $sql_upload_type;
		$uf_report[$uf_report_id]['succ'] = $file_success;
		$uf_report[$uf_report_id]['dupl'] = $upload_dupl_check;
		$uf_report[$uf_report_id]['type'] = $upload_type_check;
		$uf_report[$uf_report_id]['date'] = $upload_date_check;
		$uf_report[$uf_report_id]['file'] = $upload_file_check;
		$uf_report[$uf_report_id]['camp'] = $campaign_name_check;

	}//end foreach ($ams_csv_upload_names as $ams_csv_filename_key => $ams_csv_filename_value) 


	// ---------------------------------------------------------------------------------
	// -------- DISPLAY UPLOAD REPORT --------------------------------------------------
	// ---------------------------------------------------------------------------------

// $ams_utilities->better_vardump($acr_display_rows,3); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
// exit();		

	foreach ($uf_report as $ufr_key => $ufr_upload) {
		echo "<table class=\"zx_table\" style=\"width:100%\">";
		$acr_display_rows =  "<tr class = \"zx_bg_dark_gray zx_text_white\">";
			$acr_display_rows .=  "<th class=\"zx_align_left\">" . $ufr_upload['filename'] . "</th>";
		$acr_display_rows .=  "</tr>";
		$acr_display_rows .=  "<tr class = \"zx_bg_gray zx_text_white\">";
			$acr_display_rows .=  "<td class=\"zx_align_left\">" . $ufr_upload['sql_upload_type'] . "</td>";
		$acr_display_rows .=  "</tr>";

		foreach ($ufr_upload as $ufru_key => $ufru_value) {
		if($ufru_key=='filename')continue;
		if($ufru_key=='sql_upload_type')continue;
			$acr_display_rows .=  "<tr>";
				$acr_display_rows .=  "<td class=\"zx_align_left " . $msg_color_classes[$ufru_value] ."\" >" . $uf_codes[$ufru_key][$ufru_value] . "</td>";
			$acr_display_rows .=  "</tr>";
		}// end foreach ($ufr_upload as $ufru_key => $ufru_value)
		echo $acr_display_rows;

		echo "</table>";

	}// end foreach ($uf_report as $ufr_key => $ufr_upload)
	
// $msg_color_classes[1] = "zx_bg_alert_green";
// $msg_color_classes[0] = "zx_bg_alert_red";

// $uf_codes['date'] = [0=>'Undetermined date format in filename', 1=>'Recognized date format in filename',];
// $uf_codes['dupl'] = [0=>'Duplicate data', 1=>'New data inserted',];
// $uf_codes['file'] = [0=>'Not a CSV file', 1=>'CSV file type',];
// $uf_codes['succ'] = [0=>'Upload failed', 1=>'Upload complete',];
// $uf_codes['type'] = [0=>'Unknown AMS file type', 1=>'Identified AMS file type',];



}else{


  include "ams_includes/upload_form.php";

}//end if(isset($_POST['submit'])) 


// $ams_utilities->better_vardump($file_already_uploaded,2); //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV //VARDUMP DEV 
// exit();

?>