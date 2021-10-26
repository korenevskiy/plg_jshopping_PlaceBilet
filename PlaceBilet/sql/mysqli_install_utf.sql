
/*
INSERT INTO #__menu (  `menutype`, `title`, `alias`, `path`,`note`,  `link`, `type`, `published`, `parent_id`, `level`, `component_id`,                    `access`, `img`, `params`,  `client_id`) VALUES
('main',' ★ Магазин  ★ ', 'com_jshopping', 'com_jshopping', '',  'index.php?option=com_jshopping', 'component', 1, 1, 1, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main',' ★ Плагин  ★ ', 'placebilet', 'com_jshopping/placebilet', '',  'index.php?option=com_plugins&view=plugins&filter.search=%D0%91%D0%B8%D0%BB%D0%B5%D1%82', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main', ' ★ Модули Магазинов  ★ ','mod_jshopping_categories', 'com_jshopping/mod_jshopping_categories', '',  'index.php?option=com_modules&filter.module=mod_jshopping_categories', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main', ' ★ Загрузка Репертуаров  ★ ','loadrepertoires', 'com_jshopping/loadrepertoires', '',  '/plugins/jshopping/PlaceBilet/Libraries/index.php', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1);
*/ 

UPDATE #__extensions SET enabled = 1 WHERE  element='PlaceBilet'; 
/*
INSERT INTO `#__jshopping_currencies` ( `currency_id` , `currency_name` , `currency_code`, `currency_code_iso`, `currency_code_num` , `currency_ordering` , `currency_publish` , `currency_value` ) 
VALUES 
( NULL , 'Рублей', '₽', 'RUB', '810', '1', '1', '1.00'),
( NULL , 'Dollar', '$', 'USD', '840', '1', '1', '1.00'),
( NULL , 'Euro',   '€', 'EUR', '978', '1', '1', '1.00'),
( NULL , 'Pound',  '£', 'GBP', '826', '1', '1', '1.00'),
( NULL , '円',     '¥', 'JPY', '392', '1', '1', '1.00'),
( NULL , '元',     'Ұ', 'CNY', '156', '1', '1', '1.00');

(currency_id,currency_name,currency_code,currency_code_iso,currency_code_num,currency_ordering,currency_publish,currency_value) 
 */ 
INSERT INTO `#__jshopping_currencies` 
SELECT u.currency_id , u.currency_name , u.currency_code, u.currency_code_iso, u.currency_code_num, u.currency_ordering, u.currency_publish, u.currency_value 
FROM ( 
SELECT real_.currency_id, virtual_.*, IF( real_.currency_code_num,TRUE,FALSE) code_num   FROM ( 
SELECT   'Рублей' currency_name, '₽' currency_code, 'RUB' currency_code_iso, '810' currency_code_num, '1' currency_ordering, '1' currency_publish, '1.00' currency_value  UNION 
SELECT   'Dollar', '$', 'USD', '840', '1', '1', '1.00' UNION 
SELECT   'Euro',   '€', 'EUR', '978', '1', '1', '1.00' UNION 
SELECT   'Pound',  '£', 'GBP', '826', '1', '1', '1.00' UNION 
SELECT   '円',     '¥', 'JPY', '392', '1', '1', '1.00' UNION 
SELECT   '元',     'Ұ', 'CNY', '156', '1', '1', '1.00') virtual_  
LEFT JOIN #__jshopping_currencies real_ ON real_.currency_code_num = virtual_.currency_code_num) u 
WHERE 1 AND u.code_num = 0 ;

ALTER TABLE #__jshopping_orders ADD bonus varchar(24) NOT NULL DEFAULT '';	
ALTER TABLE #__jshopping_orders ADD address varchar(24) NOT NULL DEFAULT '';	
--ALTER TABLE #__jshopping_orders ADD address varchar(24) NOT NULL AFTER `bonus`  DEFAULT '' COMMENT '';	

ALTER TABLE #__jshopping_order_item ADD `date_event` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE #__jshopping_order_item ADD `count_places` int(4) NOT NULL DEFAULT 0;
ALTER TABLE #__jshopping_order_item ADD `places` text NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_order_item ADD `place_prices` text NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_order_item ADD `place_names` text NOT NULL DEFAULT '';

ALTER TABLE #__jshopping_orders ADD FIO varchar(255) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_FIO varchar(255) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD comment text NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_comment text NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD housing varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_housing varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD porch varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_porch varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD level varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_level varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD intercom varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_intercom varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD shiping_date varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_shiping_date varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD shiping_time varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_shiping_time varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD metro varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_metro varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD transport_name varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_transport_name varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD transport_no varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_transport_no varchar(24) NOT NULL DEFAULT '';		
ALTER TABLE #__jshopping_orders ADD track_stop varchar(24) NOT NULL DEFAULT '';
ALTER TABLE #__jshopping_orders ADD d_track_stop varchar(24) NOT NULL DEFAULT '';




ALTER TABLE #__jshopping_attr ADD attr_admin_type int(3) NOT NULL  DEFAULT 0;
ALTER TABLE #__jshopping_products ADD date_event datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;


        ALTER TABLE #__jshopping_attr ADD StageCatId int(11) NOT NULL DEFAULT 0;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD `Row` varchar(24) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD SectorId int(11) NOT NULL DEFAULT 0;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD StageId int(11) NOT NULL DEFAULT 0;   -- Зрители


        ALTER TABLE #__jshopping_products ADD params text NOT NULL DEFAULT '';   -- Зрители
        ALTER TABLE #__jshopping_products ADD RepertoireId int(11) NOT NULL DEFAULT 0;   -- Зрители
        ALTER TABLE #__jshopping_products ADD StageId int(11) NOT NULL DEFAULT 0;   -- Зрители


        ALTER TABLE #__jshopping_categories ADD PlaceId int(11) NOT NULL DEFAULT 0;   -- Зрители
        ALTER TABLE #__jshopping_categories ADD StageId int(11) NOT NULL DEFAULT 0;   -- Зрители
        ALTER TABLE #__jshopping_categories ADD RepertoireId int(11) NOT NULL DEFAULT 0;   -- Зрители

        ALTER TABLE #__jshopping_products_attr2 ADD OfferId int(11) NOT NULL DEFAULT 0;   -- Зрители



UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
SET us.location= REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.')
WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id;

 