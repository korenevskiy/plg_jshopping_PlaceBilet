
INSERT INTO #__menu (  `menutype`, `title`, `alias`, `path`,`note`,  `link`, `type`, `published`, `parent_id`, `level`, `component_id`,                    `access`, `img`, `params`,  `client_id`) VALUES
('main',' ★ Магазин  ★ ', 'com_jshopping', 'com_jshopping', '',  'index.php?option=com_jshopping', 'component', 1, 1, 1, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main',' ★ Плагин  ★ ', 'placebilet', 'com_jshopping/placebilet', '',  'index.php?option=com_plugins&view=plugins&filter.search=%D0%91%D0%B8%D0%BB%D0%B5%D1%82', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main', ' ★ Модули Магазинов  ★ ','mod_jshopping_categories', 'com_jshopping/mod_jshopping_categories', '',  'index.php?option=com_modules&filter.module=mod_jshopping_categories', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1),
('main', ' ★ Загрузка Репертуаров  ★ ','loadrepertoires', 'com_jshopping/loadrepertoires', '',  '/plugins/jshopping/PlaceBilet/Libraries/index.php', 'component', 1, 1, 2, 1,        1, 'components/com_jshopping/images/jshop_logo_s.png',  '{}', 1);

ALTER TABLE #__jshopping_orders ADD bonus varchar(24) NOT NULL;	
ALTER TABLE #__jshopping_orders ADD address varchar(24) NOT NULL;	

ALTER TABLE #__jshopping_order_item ADD `date_event` datetime NOT NULL;
ALTER TABLE #__jshopping_order_item ADD `count_places` int(4) NOT NULL;
ALTER TABLE #__jshopping_order_item ADD `places` text NOT NULL;
ALTER TABLE #__jshopping_order_item ADD `place_prices` text NOT NULL;
ALTER TABLE #__jshopping_order_item ADD `place_names` text NOT NULL;
ALTER TABLE #__jshopping_orders ADD FIO varchar(255) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_FIO varchar(255) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD comment text NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_comment text NOT NULL;		
ALTER TABLE #__jshopping_orders ADD housing varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_housing varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD porch varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_porch varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD level varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_level varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD intercom varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_intercom varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD shiping_date varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_shiping_date varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD shiping_time varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_shiping_time varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD metro varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_metro varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD transport_name varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_transport_name varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD transport_no varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_transport_no varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_orders ADD track_stop varchar(24) NOT NULL;
ALTER TABLE #__jshopping_orders ADD d_track_stop varchar(24) NOT NULL;

ALTER TABLE #__jshopping_users ADD FIO varchar(255) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_FIO varchar(255) NOT NULL;		
ALTER TABLE #__jshopping_users ADD comment text NOT NULL;
ALTER TABLE #__jshopping_users ADD d_comment text NOT NULL;		
ALTER TABLE #__jshopping_users ADD housing varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_housing varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD porch varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_porch varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD level varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_level varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD intercom varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_intercom varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD shiping_date varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_shiping_date varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD shiping_time varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_shiping_time varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD metro varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_metro varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD transport_name varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_transport_name varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD transport_no varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_transport_no varchar(24) NOT NULL;		
ALTER TABLE #__jshopping_users ADD track_stop varchar(24) NOT NULL;
ALTER TABLE #__jshopping_users ADD d_track_stop varchar(24) NOT NULL;


ALTER TABLE #__jshopping_attr ADD attr_admin_type int(3) NOT NULL;
        ALTER TABLE #__jshopping_attr ADD StageCatId int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD `Row` int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD SectorId int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_attr ADD StageId int(11) NOT NULL;   -- Зрители

ALTER TABLE #__jshopping_products ADD date_event datetime NOT NULL;

        ALTER TABLE #__jshopping_products ADD params text NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_products ADD RepertoireId int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_products ADD StageId int(11) NOT NULL;   -- Зрители


        ALTER TABLE #__jshopping_categories ADD PlaceId int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_categories ADD StageId int(11) NOT NULL;   -- Зрители
        ALTER TABLE #__jshopping_categories ADD RepertoireId int(11) NOT NULL;   -- Зрители

        ALTER TABLE #__jshopping_products_attr2 ADD OfferId int(11) NOT NULL;   -- Зрители


