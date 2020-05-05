<?php

/*
NEEDS the following improvements

Nothing so far


*/


// UPDATE `keyword_harvest` SET `kh_char_clean_up` = '0', `kh_char_count` = '0', `kh_word_count` = '0' WHERE `keyword_harvest`.`kh_id` = 1


# ---------------------------------------------------------------
# ---------- CONFIG STUFF ---------------------------------------
# ---------------------------------------------------------------


# ----- Business logic reminder  ------------------------------------------
/*
SOURCE: https://kdp.amazon.com/en_US/help/topic/G202076750
Keywords aren't case-sensitive - Maximum limit of 10 words per keyword and 80 characters.
Keywords can contain letters, numbers, or spaces, but cannot contain punctuation or special characters such as a pound sign, comma, or apostrophe.

SOURCE: sql_baseline.sql
kh_passed_black_list		TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2-review, 3-kill',
kh_char_clean_up			TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-done', 
kh_char_count				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2- text too long, 3- author too long, 5- both too long', 
kh_word_count				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2- text too many, 3- author too many, 5- both too many', 

*/
# ----- Review list Color classes  ------------------------------------------
$review_list_color_classes[0] = "zx_bg_alert_blue";// No value shold remain at zero after treatment but we never know - also scalability in mind
$review_list_color_classes[1] = "zx_bg_alert_green";
$review_list_color_classes[2] = "zx_bg_alert_orange";
$review_list_color_classes[3] = "zx_bg_alert_red";
$review_list_color_classes[4] = "zx_bg_alert_red";// No value should add to 4 - only set for code aestetics and scalabilty
$review_list_color_classes[5] = "zx_bg_alert_red";

# ----- Review list Codes  ------------------------------------------
$review_list_pbl_codes = [0=>'tbd', 1=>'OK', 2=>'Review', 3=>'Kill'];
$review_list_ccu_codes = [0=>'tbd', 1=>'Done',];
$review_list_cc_codes = [0=>'tbd', 1=>'OK', 2=>'Kw' , 3=>'Auth' , 5=> 'Both' ];
$review_list_wc_codes = [0=>'tbd', 1=>'OK', 2=>'Kw' , 3=>'Auth' , 5=> 'Both' ];

# ----- Regex & Constraints ------------------------------------------
$kw_special_chars_pattern['special_chars'] = "/[^a-z 0-9 \s]/i";
$kw_maxlength = 80;
$kw_maxwords  = 10;

# ---------------------------------------------------------------
# ---------- DATA RETRIEVAL -------------------------------------
# ---------------------------------------------------------------
$query_kh = " SELECT  * FROM " . DB_KEYWORD_HARVEST_TABLE . " WHERE ";
$query_kh .= " kh_passed_black_list = :kh_passed_black_list OR ";
$query_kh .= " kh_char_clean_up = :kh_char_clean_up OR ";
$query_kh .= " kh_char_count = :kh_char_count OR ";
$query_kh .= " kh_word_count = :kh_word_count   ;";

$params_kh['kh_passed_black_list'] = 0; 
$params_kh['kh_char_clean_up'] = 0; 
$params_kh['kh_char_count'] = 0; 
$params_kh['kh_word_count'] = 0; 

$kw_harvest_raw = $ams_utilities->sql_get_all_rows($query_kh, $params_kh);

# ---------------------------------------------------------------
# ---------- CLEANING AND FLAGGING ------------------------------
# ---------------------------------------------------------------

// $xx=0;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing

foreach ($kw_harvest_raw as $khr_key => $khr_value) {

// $ams_utilities->better_vardump($kw_harvest_raw[$khr_key],2);// 0- green; 1-red; 2-grey; 3-yellow   

	// Cleaning special characters ---------------
	$khr_temp_t = preg_replace("/&/"," and ",$khr_value['kh_keyword_text']); // preserve the value of the ampersand 
	$khr_temp_a = preg_replace("/&/"," and ",$khr_value['kh_keyword_author']); // preserve the value of the ampersand 

	$kw_harvest_raw[$khr_key]['kh_keyword_text'] = preg_replace($kw_special_chars_pattern, "", $khr_temp_t); // brute force approach...
	$kw_harvest_raw[$khr_key]['kh_keyword_author'] = preg_replace($kw_special_chars_pattern, "", $khr_temp_a); // brute force approach...
	$kw_harvest_raw[$khr_key]['kh_char_clean_up'] = 1;

	// Flagging char count overflow ---------------
	if(strlen($khr_temp_t)>$kw_maxlength)  $kw_harvest_raw[$khr_key]['kh_char_count'] += 2; // possible values are 0 or 0+2
	if(strlen($khr_temp_a)>$kw_maxlength)  $kw_harvest_raw[$khr_key]['kh_char_count'] += 3; // possible values are 0 or 0+3 or 0+2+3
	if($kw_harvest_raw[$khr_key]['kh_char_count']==0) $kw_harvest_raw[$khr_key]['kh_char_count']=1; // if passed, value = 1

	// Flagging word count overflow ---------------
	if(count(preg_split('/\s/', $khr_temp_t))>$kw_maxwords)  $kw_harvest_raw[$khr_key]['kh_word_count'] += 2; // possible values are 0 or 0+2
	if(count(preg_split('/\s/', $khr_temp_a))>$kw_maxwords)  $kw_harvest_raw[$khr_key]['kh_word_count'] += 3; // possible values are 0 or 0+3 or 0+2+3
	if($kw_harvest_raw[$khr_key]['kh_word_count']==0) $kw_harvest_raw[$khr_key]['kh_word_count']=1; // if passed, value = 1

// $ams_utilities->better_vardump($kw_harvest_raw[$khr_key],3);// 0- green; 1-red; 2-grey; 3-yellow   
	
	

// $xx++; if ($xx==5) break;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing

}//end foreach ($kw_harvest_raw as $khr_key => $khr_value)

$ams_utilities->better_vardump("<br>Clean up  done",0);// 0- green; 1-red; 2-grey; 3-yellow   


# ---------------------------------------------------------------
# ---------- BLACK LIST CHALLENGE -------------------------------
# ---------------------------------------------------------------

	$kw_grey_list_pattern="/\d(st|nd|rd|th)/i";


	# ----- Black List Data retrieval ------------------------------------------
	$query_kbl = " SELECT  * FROM " . DB_KEYWORD_BLACK_LIST_TABLE;
	$params_kbl=[]; 

	$kw_black_list = $ams_utilities->sql_get_all_rows($query_kbl, $params_kbl);


// $xx=0;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing
foreach ($kw_harvest_raw as $khr_key => $khr_value) {
	foreach ($kw_black_list as $kbl_key => $kbl_value) {

		$text =  $kbl_value['kbl_text'];
		$tword =  $kbl_value['kbl_word'];

		if(1===preg_match("/$text/i",$khr_value['kh_keyword_text'])) {
		$kw_harvest_raw[$khr_key]['kh_passed_black_list'] = $tword;// Possible values: 0, 1, 2
		break;
		}// end if

// $xx++; if ($xx==5) break;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing

	}// end foreach ($kw_black_list as $kbl_key => $kbl_value) 
	$kw_harvest_raw[$khr_key]['kh_passed_black_list'] += 1;// Possible values: 1-passed, 2-review, 3-kill

	# figure out which author and keyword are blackisted

	# from table




	# special cases - only if not KILLED BY above code



}//end foreach ($kw_harvest_raw as $khr_key => $khr_value)


$ams_utilities->better_vardump("<br>Black List challenge  done",2);// 0- green; 1-red; 2-grey; 3-yellow   

//VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP //VARDUMP 
// $ams_utilities->better_vardump($kw_harvest_raw,2);// 0- green; 1-red; 2-grey; 3-yellow   
// exit();

# ---------------------------------------------------------------
# ---------- UPDATE DATABASE ------------------------------------
# ---------------------------------------------------------------

## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 
## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 
## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 

// foreach ($kw_harvest_raw as $khr_key => $khr_value) {


// 	// Update database ----------------------------
// 	$query_khr = " UPDATE " . DB_KEYWORD_HARVEST_TABLE . " SET ";
// 	$query_khr .= " kh_keyword_text = :kh_keyword_text, ";
// 	$query_khr .= " kh_keyword_author = :kh_keyword_author, ";
// 	$query_khr .= " kh_passed_black_list = :kh_passed_black_list, ";
// 	$query_khr .= " kh_char_clean_up = :kh_char_clean_up, ";
// 	$query_khr .= " kh_char_count = :kh_char_count, ";
// 	$query_khr .= " kh_word_count = :kh_word_count  ";
// 	$query_khr .= " WHERE kh_id = :kh_id ";

// 	$params_khr['kh_keyword_text'] = $kw_harvest_raw[$khr_key]['kh_keyword_text'];
// 	$params_khr['kh_keyword_author'] = $kw_harvest_raw[$khr_key]['kh_keyword_author'];
// 	$params_khr['kh_passed_black_list'] = $kw_harvest_raw[$khr_key]['kh_passed_black_list'];
// 	$params_khr['kh_char_clean_up'] = $kw_harvest_raw[$khr_key]['kh_char_clean_up'];
// 	$params_khr['kh_char_count'] = $kw_harvest_raw[$khr_key]['kh_char_count'];
// 	$params_khr['kh_word_count'] = $kw_harvest_raw[$khr_key]['kh_word_count'];
// 	$params_khr['kh_id'] = $kw_harvest_raw[$khr_key]['kh_id'];

// 	$ams_utilities->sql_execute($query_khr, $params_khr);

// }//end foreach ($kw_harvest_raw as $khr_key => $khr_value)


## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 
## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 
## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## ## SKIP FOR NOW ## 


$ams_utilities->better_vardump("<br>Update datebase  done",0);// 0- green; 1-red; 2-grey; 3-yellow   


# ---------------------------------------------------------------
# -------- list KWs in front end for review and approval --------
# ---------------------------------------------------------------


echo "<table class=\"zx_table\">";

	$khr_display_row =  "<tr class = \"zx_bg_dark_gray zx_text_white\">";
		$khr_display_row .=  "<th class=\"zx_align_center\">K id</th>";
		$khr_display_row .=  "<th class=\"zx_align_left\">Keyword</th>";
		$khr_display_row .=  "<th class=\"zx_align_left\">Author</th>";
		$khr_display_row .=  "<th class=\"zx_align_center\">Black List</th>";
		$khr_display_row .=  "<th class=\"zx_align_center\">Clean Up</th>";
		$khr_display_row .=  "<th class=\"zx_align_center\">Char Count</th>";
		$khr_display_row .=  "<th class=\"zx_align_center\">Word Count</th>";
	$khr_display_row .=  "<tr>";

echo $khr_display_row;

// $xx=0;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing
foreach ($kw_harvest_raw as $khr_key => $khr_value) {

	// $ams_utilities->better_vardump($kw_harvest_raw[$khr_key],2);// 0- green; 1-red; 2-grey; 3-yellow   
	$khr_temp_i = 	$khr_value['kh_id']; 
	$khr_temp_t = 	$khr_value['kh_keyword_text']; 
	$khr_temp_a = 	$khr_value['kh_keyword_author']; 
	$khr_temp_pbl = $khr_value['kh_passed_black_list']; 
	$khr_temp_ccu = $khr_value['kh_char_clean_up']; 
	$khr_temp_cc = 	$khr_value['kh_char_count']; 
	$khr_temp_wc = 	$khr_value['kh_word_count'];




	$khr_display_row =  "<tr>";
		$khr_display_row .=  "<td class=\"zx_align_center\">$khr_temp_i</td>";
		$khr_display_row .=  "<td title = \"$khr_temp_t\">" . mb_strimwidth($khr_temp_t,0,30,"&#133;") ."</td>";
		$khr_display_row .=  "<td title = \"$khr_temp_a\">" . mb_strimwidth($khr_temp_a,0,30,"&#133;") ."</td>";
		$khr_display_row .=  "<td class=\"zx_align_center " . $review_list_color_classes[$khr_temp_pbl] . "\">" . $review_list_pbl_codes[$khr_temp_pbl] . "</td>";
		$khr_display_row .=  "<td class=\"zx_align_center " . $review_list_color_classes[$khr_temp_ccu] . "\">" . $review_list_ccu_codes[$khr_temp_ccu] . "</td>";
		$khr_display_row .=  "<td class=\"zx_align_center " . $review_list_color_classes[$khr_temp_cc] . "\">" . $review_list_cc_codes[$khr_temp_cc] . "</td>";
		$khr_display_row .=  "<td class=\"zx_align_center " . $review_list_color_classes[$khr_temp_wc] . "\">" . $review_list_wc_codes[$khr_temp_wc] . "</td>";
	$khr_display_row .=  "<tr>";

echo $khr_display_row;

// $xx++; if ($xx==5) break;//// to limit iterations during testing//// to limit iterations during testing//// to limit iterations during testing//// 

}//end foreach ($kw_harvest_raw as $khr_key => $khr_value)

echo "</table>";





# other KWs are discarded in some way - TRUNCATE DB_KEYWORD_HARVEST_TABLE??? maybe keep DB_KEYWORD_HARVEST_TABLE for review and TRUNCATE later???
# DB_KEYWORD_HARVEST_TABLE required uploads - is that a lot of work worth keeping???

# Approved KWs are gathered under a single list (PRE-MASTER TABLE) with their associated types

# remove duplicates from  PRE-MASTER TABLE - DISTINCT ???

# check for duplicate against MASTER TABLE and discard

# insert in MASTER TABLE




?>

