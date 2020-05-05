

-- -------------------------------------------------------
-- -------- VERIFIED QUERIES  ----------------------------
-- -------------------------------------------------------

SELECT DISTINCT(cr_report_date) FROM campaign_reports ORDER BY cr_report_date;

SELECT DISTINCT(cr_campaign_name) FROM campaign_reports ORDER BY cr_campaign_name;

SELECT * FROM campaign_reports ORDER BY cr_report_date, cr_campaign_name



-- All Campaign results on last report (if a campaign was removed from portfolio before that date, it does not show up here)
SELECT cr_1.cr_report_date, cr_1.cr_campaign_name, cr_1.cr_campaign_impressions, cr_1.cr_campaign_clicks, cr_1.cr_campaign_orders 
FROM campaign_reports cr_1
WHERE cr_report_date IN (SELECT MAX(cr_2.cr_report_date) FROM campaign_reports cr_2) 
ORDER BY cr_1.cr_campaign_name;

-- -------------------------------------------------------

SELECT 
cr_report_date,
cr_campaign_name,
cr_campaign_impressions,
cr_campaign_clicks,
cr_campaign_ctr,
cr_campaign_spend,
cr_campaign_cpc,
cr_campaign_orders,
cr_campaign_sales,
cr_campaign_acos 
FROM campaign_reports 
ORDER BY cr_report_date, cr_campaign_name;

-- -------------------------------------------------------

SELECT 
cr_report_date,
cr_campaign_name,
cr_campaign_impressions,
cr_campaign_clicks,
cr_campaign_ctr,
cr_campaign_spend,
cr_campaign_cpc,
cr_campaign_orders,
cr_campaign_sales,
cr_campaign_acos 
FROM campaign_reports 
ORDER BY  cr_campaign_name, cr_report_date;

-- -------------------------------------------------------

SELECT 
cr_report_date,
cr_campaign_name,
cr_campaign_impressions,
cr_campaign_clicks,
cr_campaign_ctr,
cr_campaign_spend,
cr_campaign_cpc,
cr_campaign_orders,
cr_campaign_sales,
cr_campaign_acos 
FROM campaign_reports 
WHERE cr_campaign_name = 'LBM - Kindle - 3 - fka Inspirational'
ORDER BY   cr_report_date;


-- -------------------------------------------------------
-- -------- kw_meta_analysis -----------------------
-- -------------------------------------------------------

# RENAME TABLE ams_reports.table 4 TO ams_reports.kw_meta_analysis;

SELECT DISTINCT(Campaign) FROM kw_meta_analysis LIMIT 0,100;

SELECT Campaign, COUNT(Keyword) AS kw_count, SUM(Impressions) AS sum_imp, SUM(Clicks) AS sum_click, SUM(Orders) AS sum_orders
FROM kw_meta_analysis
GROUP BY Campaign
ORDER By sum_orders DESC, sum_click DESC, sum_imp DESC
LIMIT 0,100;

-- -------------------------------------------------------
-- -------- CAMPAIGN REPORTS -----------------------------
-- -------------------------------------------------------



-- Campaign analysis 
SELECT cr_report_date, count(cr_campaign_name), SUM(cr_campaign_impressions), SUM(cr_campaign_clicks), SUM(cr_campaign_orders) 
FROM campaign_reports 
GROUP BY cr_report_date 
ORDER BY cr_report_date;


-- Simple campaign retrieval
SELECT cr_1.cr_report_date, cr_1.cr_campaign_name, cr_1.cr_campaign_impressions, cr_1.cr_campaign_clicks, cr_1.cr_campaign_orders
FROM campaign_reports cr_1
ORDER BY   cr_1.cr_campaign_name, cr_1.cr_report_date DESC


-- Get top 2 dates
SELECT DISTINCT(cr_1.cr_report_date) FROM campaign_reports cr_1 ORDER BY cr_1.cr_report_date DESC LIMIT 1,2

-- run the query for each day
-- last report day
SELECT cr_report_date, count(cr_campaign_name), SUM(cr_campaign_impressions), SUM(cr_campaign_clicks), SUM(cr_campaign_orders) 
FROM campaign_reports 
WHERE cr_report_date = '2020-04-26'
GROUP BY cr_report_date ;

-- Day before last report day
SELECT cr_report_date, count(cr_campaign_name), SUM(cr_campaign_impressions), SUM(cr_campaign_clicks), SUM(cr_campaign_orders) 
FROM campaign_reports 
WHERE cr_report_date = '2020-04-24'
GROUP BY cr_report_date ;


-- UPDATE campaign_reports SET cr_campaign_name =  REPLACE(cr_campaign_name, "- ", ""); #Old campaign names had dashes
