 
 
/*
INSERT INTO #__jshopping_currencies (currency_id,currency_name,currency_code,currency_code_iso,currency_code_num,currency_ordering,currency_publish,currency_value) 
SELECT NULL, CONCAT('0.3_',CURTIME(),' ||',count(*),'||',GROUP_CONCAT(element SEPARATOR ', ')),'₽','RUB','810','1','1','1.00'
FROM #__extensions WHERE  element LIKE '%jshopping%' OR element='PlaceBilet';*/

--SELECT  NULL ,  CONCAT( '0.3_',CURTIME()), '₽', 'RUB', '810', '1', '1', '1.00'; 
