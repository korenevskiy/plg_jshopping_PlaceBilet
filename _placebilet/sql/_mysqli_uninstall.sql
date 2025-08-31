 
 


 



ALTER TABLE #__jshopping_orders  DROP COLUMN bonus ;	
ALTER TABLE #__jshopping_orders  DROP COLUMN address ;	 

ALTER TABLE #__jshopping_order_item  DROP COLUMN `date_event` ;
ALTER TABLE #__jshopping_order_item  DROP COLUMN `count_places`;
ALTER TABLE #__jshopping_order_item  DROP COLUMN `places`;
ALTER TABLE #__jshopping_order_item  DROP COLUMN `place_prices`;
ALTER TABLE #__jshopping_order_item  DROP COLUMN `place_names`;

ALTER TABLE #__jshopping_orders  DROP COLUMN FIO ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_FIO ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN `comment`;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_comment;		
ALTER TABLE #__jshopping_orders  DROP COLUMN housing ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_housing ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN porch ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_porch ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN `level` ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_level ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN intercom ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_intercom ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN shiping_date ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_shiping_date ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN shiping_time ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_shiping_time ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN metro ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_metro ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN transport_name ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_transport_name ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN transport_no ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_transport_no ;		
ALTER TABLE #__jshopping_orders  DROP COLUMN track_stop ;
ALTER TABLE #__jshopping_orders  DROP COLUMN d_track_stop ;




ALTER TABLE #__jshopping_attr  DROP COLUMN attr_admin_type ;
ALTER TABLE #__jshopping_products  DROP COLUMN date_event ;


        ALTER TABLE #__jshopping_attr  DROP COLUMN StageCatId ;   -- Зрители
        ALTER TABLE #__jshopping_attr  DROP COLUMN `Row` ;   -- Зрители
        ALTER TABLE #__jshopping_attr  DROP COLUMN SectorId ;   -- Зрители
        ALTER TABLE #__jshopping_attr  DROP COLUMN StageId ;   -- Зрители


        ALTER TABLE #__jshopping_products  DROP COLUMN params;   -- Зрители
        ALTER TABLE #__jshopping_products  DROP COLUMN RepertoireId ;   -- Зрители
        ALTER TABLE #__jshopping_products  DROP COLUMN StageId ;   -- Зрители


        ALTER TABLE #__jshopping_categories  DROP COLUMN PlaceId ;   -- Зрители
        ALTER TABLE #__jshopping_categories  DROP COLUMN StageId ;   -- Зрители
        ALTER TABLE #__jshopping_categories  DROP COLUMN RepertoireId ;   -- Зрители

        ALTER TABLE #__jshopping_products_attr2  DROP COLUMN OfferId ;   -- Зрители

 