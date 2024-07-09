CREATE VIEW view_benefit_month AS 
SELECT 
    user_id,
    SUM(benefit) AS benefit_value,
    SUM(price) AS price_value,
    (SUM(benefit) / SUM(price)) * 100 AS benefit_pourcent,
    DATE_FORMAT(created_at, '%Y') AS years,
    DATE_FORMAT(created_at, '%m') AS month,
    DATE_FORMAT(created_at, '%Y-%m') AS date_full
FROM
    sale
GROUP BY
    user_id,
    DATE_FORMAT(created_at, '%Y'),
    DATE_FORMAT(created_at, '%m'),
    DATE_FORMAT(created_at, '%Y-%m');