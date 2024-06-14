SELECT 
job.job_no
,job.appointment_date
,mo.model_code
,mo.model_name
,cus_b.branch_code
,cus_b.branch_name
,cus.customer_name
,pro.install_date
,job.close_datetime
,job.finish_service_time
,job.list_pm_job
FROM `tbl_job` job
JOIN tbl_product pro ON job.product_id = pro.product_id
JOIN tbl_product_model mo ON pro.model_id = mo.model_id
JOIN tbl_customer_branch cus_b ON job.customer_branch_id = cus_b.customer_branch_id
JOIN tbl_customer cus ON cus_b.customer_id = cus.customer_id
WHERE job_type = '2' AND start_service_time IS NULL AND close_datetime IS NULL;

SELECT 
job.job_no
,job.create_datetime
,job.appointment_date
,mo.model_code
,mo.model_name
,cus_b.branch_code
,cus_b.branch_name
,cus.customer_name
,pro.install_date
,job.close_datetime
,job.finish_service_time
,job.list_pm_job
FROM `tbl_job` job
JOIN tbl_product pro ON job.product_id = pro.product_id
JOIN tbl_product_model mo ON pro.model_id = mo.model_id
JOIN tbl_customer_branch cus_b ON job.customer_branch_id = cus_b.customer_branch_id
JOIN tbl_customer cus ON cus_b.customer_id = cus.customer_id
WHERE job_type = '2'  
AND YEAR(job.create_datetime) = '2024';


SELECT 
job.job_no AS หมายเลขงาน
,job.create_datetime AS วันที่เปิดงาน
,job.appointment_date AS วันที่นัดหมาย
,mo.model_code AS รหัสรุ่น
,mo.model_name AS ชื่อรุ่น
,cus_b.branch_code AS รหัสสาขา
,cus_b.branch_name AS ชื่อสาขา
,cus.customer_name AS ชื่อลูกค้า
,pro.install_date AS วันที่ติดตั้ง
,job.finish_service_time AS วันที่Checkout
,job.close_datetime AS วันที่ปิดงาน
,job.list_pm_job AS ลำดับPM
FROM `tbl_job` job
JOIN tbl_product pro ON job.product_id = pro.product_id
JOIN tbl_product_model mo ON pro.model_id = mo.model_id
JOIN tbl_customer_branch cus_b ON job.customer_branch_id = cus_b.customer_branch_id
JOIN tbl_customer cus ON cus_b.customer_id = cus.customer_id
WHERE job_type = '2'  
AND YEAR(job.create_datetime) = '2024';