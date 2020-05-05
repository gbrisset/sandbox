


-- ALTER TABLE `keyword_harvest` ADD  		kh_passed_black_list	TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2-kill' AFTER `kh_keyword_author`;
-- ALTER TABLE `keyword_harvest` CHANGE `kh_char_count` 		kh_char_count				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2- text too many, 3- author too many, 5- both too many';


	-- -------------------------------------------------------
	-- -------- TABLE CAMPAIGN_REPORTS -----------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.campaign_reports ;

	CREATE TABLE ams_reports.campaign_reports (

	  cr_id 						INT NOT NULL AUTO_INCREMENT ,
	  cr_report_date 				DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	  
	-- -------- Columns from AMS report ----------------------

	  cr_campaign_state				VARCHAR(50) NOT NULL ,
	  cr_campaign_name				VARCHAR(50) NOT NULL ,
	  cr_campaign_status			VARCHAR(50) NOT NULL ,

	  cr_campaign_type				VARCHAR(50) NOT NULL ,
	  cr_campaign_targeting			VARCHAR(50) NOT NULL ,
	  cr_campaign_bidding_strategy	VARCHAR(50) NOT NULL ,

	  cr_campaign_start_date		DATETIME ,
	  cr_campaign_end_date			DATETIME ,
	  
	  cr_campaign_portfolio			VARCHAR(50) NOT NULL ,
	  cr_campaign_budget			VARCHAR(50) NOT NULL ,

	  cr_campaign_impressions		INT UNSIGNED  NOT NULL ,
	  cr_campaign_clicks			MEDIUMINT UNSIGNED NOT NULL ,
	  
	  cr_campaign_ctr				DECIMAL(5,4) NOT NULL ,
	  cr_campaign_spend				DECIMAL(6,2) NOT NULL ,
	  cr_campaign_cpc				DECIMAL(6,2) NOT NULL ,
	  
	  cr_campaign_orders			MEDIUMINT UNSIGNED NOT NULL ,
	  cr_campaign_sales				DECIMAL(7,2) NOT NULL ,
	  cr_campaign_acos				DECIMAL(6,2) NOT NULL ,
	  
	  PRIMARY KEY (cr_id)) ENGINE = InnoDB;




	-- -------------------------------------------------------
	-- -------- TABLE KEYWORD_REPORTS -----------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.keyword_reports ;

	CREATE TABLE ams_reports.keyword_reports (

		kr_id 						INT NOT NULL AUTO_INCREMENT ,
		kr_report_date 				DATETIME NOT NULL ,
		kr_campaign_name			VARCHAR(50) NOT NULL ,
	  
	-- -------- Columns from AMS report ----------------------


		kr_keyword_state			VARCHAR(50) NOT NULL,
		kr_keyword_name				VARCHAR(100) NOT NULL ,

		kr_keyword_match_type		VARCHAR(50) NOT NULL, -- this column is absent in ASIN CAT reports
		kr_keyword_status			VARCHAR(50) NOT NULL,

		kr_keyword_sugg_bid_low		DECIMAL(4,2) NOT NULL ,
		kr_keyword_sugg_bid_med		DECIMAL(4,2) NOT NULL ,
		kr_keyword_sugg_bid_high	DECIMAL(4,2) NOT NULL ,
		kr_keyword_keyword_bid		DECIMAL(4,2) NOT NULL ,

		kr_keyword_impressions		INT UNSIGNED  NOT NULL ,
		kr_keyword_clicks			MEDIUMINT UNSIGNED NOT NULL ,

		kr_keyword_ctr				DECIMAL(5,4) NOT NULL ,
		kr_keyword_spend			DECIMAL(6,2) NOT NULL ,
		kr_keyword_cpc				DECIMAL(6,2) NOT NULL ,

		kr_keyword_orders			MEDIUMINT UNSIGNED NOT NULL ,
		kr_keyword_sales			DECIMAL(7,2) NOT NULL ,
		kr_keyword_acos				DECIMAL(6,2) NOT NULL ,

	  PRIMARY KEY (kr_id)) ENGINE = InnoDB;




	-- -------------------------------------------------------
	-- -------- TABLE KEYWORD_MASTER -----------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.keyword_master ;

	CREATE TABLE ams_reports.keyword_master (

		km_id 						INT NOT NULL AUTO_INCREMENT ,
		km_keyword_text				VARCHAR(100) NOT NULL ,
		km_keyword_type				VARCHAR(50) NOT NULL, -- Title, Author, regular kw

		-- km_xxxxxxxxxx_tbd
		-- km_xxxxxxxxxx_tbd
		-- km_xxxxxxxxxx_tbd

	  PRIMARY KEY (km_id)) AUTO_INCREMENT=1000 ENGINE = InnoDB;


	-- -------------------------------------------------------
	-- -------- TABLE KEYWORD_HARVEST -----------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.keyword_harvest ;

	CREATE TABLE ams_reports.keyword_harvest (

		kh_id 						INT NOT NULL AUTO_INCREMENT ,
		kh_keyword_text				VARCHAR(100) NOT NULL ,
		kh_keyword_author			VARCHAR(100) NULL, -- Need to filter the title/author pair as a whole at this stage :: author  <=> title  | no author <=> regular kw 
		kh_passed_black_list		TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2-review, 3-kill', 
		kh_char_clean_up			TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-done', 
		kh_char_count				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2- text too long, 3- author too long, 5- both too long', 
		kh_word_count				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2- text too many, 3- author too many, 5- both too many',
	  PRIMARY KEY (kh_id)) AUTO_INCREMENT=1000  ENGINE = InnoDB;

-- kh_passed_black_list applies to both kh_keyword_text AND kh_keyword_author TOGETHER	since if either one is rejected, the other has no valid reason to remain


	-- -------------------------------------------------------
	-- -------- TABLE KEYWORD_FLOATING -----------------------
	-- -------------------------------------------------------

# THIS TABLE MIGHT BE A VIEW or just a PHP array in the code - IT IS INTENDED AS REPO BETWEEN KEYWORD_HARVEST AND INSERT INTO KEYWORD_MASTER
	-- DROP TABLE IF EXISTS ams_reports.keyword_floating ;

	-- CREATE TABLE ams_reports.keyword_floating (

	-- 	kf_id 						INT NOT NULL AUTO_INCREMENT ,
	-- 	kf_keyword_text				VARCHAR(100) NOT NULL , -- can be title, author, or regular kw
	-- 	kf_is_duplicate				TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2-kill', 
	-- 	kf_is_already_in_master		TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-tbd, 1-passed, 2-kill', 

	--   PRIMARY KEY (kf_id)) ENGINE = InnoDB;
# ##################################################################################################################

	-- -------------------------------------------------------
	-- -------- TABLE KEYWORD_BLACK_LIST ------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.keyword_black_list ;

	CREATE TABLE ams_reports.keyword_black_list (

		kbl_id 			INT NOT NULL AUTO_INCREMENT ,
		kbl_text		VARCHAR(100) NOT NULL ,
		kbl_author		VARCHAR(100) NOT NULL ,
		kbl_word		TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'If KW contains text:  0-ignore, 1-review, 2-kill', 
		kbl_bow			TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'If KW begins w/ text: 0-ignore, 1-review, 2-kill', 
		kbl_eow			TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'If KW ends w/ text:   0-ignore, 1-review, 2-kill', 
		kbl_campaign	TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'If KW contains text:  0-ignore, 1-review, 2-negative_targeting', 


	  PRIMARY KEY (kbl_id)) AUTO_INCREMENT=1000  ENGINE = InnoDB;



	-- -------------------------------------------------------
	-- -------- TABLE UPLOADED_FILES -----------------------
	-- -------------------------------------------------------

	DROP TABLE IF EXISTS ams_reports.uploaded_files ;

	CREATE TABLE ams_reports.uploaded_files (

		uf_id 				INT NOT NULL AUTO_INCREMENT ,
		uf_upload_date 		DATETIME NOT NULL ,
		uf_filename			VARCHAR(50) NOT NULL ,
	  
	  PRIMARY KEY (uf_id)) AUTO_INCREMENT=1000  ENGINE = InnoDB;



