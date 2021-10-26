/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
    
//    jQuery('#placebilet').accordion({header: "> .ui-accordion-content > .ui-accordion-header",
//            heightStyle:'content', autoHeight:false,collapsible:true, active: 0}); 
    //return;
    
        
    
    jQuery('#placebilet > .ui-accordion-content > .attributes_side').animate({height:'0'}, 4000,  function(){
        //return;
        var width = jQuery('.ui-accordion').width();        
        jQuery("<style>").prop("type", "text/css").html("#placebilet .ui-accordion-content{width:auto;}\n\
    #placebilet .ui-accordion-content-active{width:"+width+"px;}").appendTo("head");
        
        jQuery('.inpt_radio').remove();
        
        //console.log(jQuery('.ui-accordion').width());
        //jQuery('.ui-accordion').css('align-items','stretch');
        
        jQuery('#placebilet > .ui-accordion-content > .attributes_side').css('height','auto').css('display','none');
        jQuery('#placebilet').accordion({header: "> .ui-accordion-content > .ui-accordion-header",
            heightStyle:'content', autoHeight:false,collapsible:true, active: 0}); 
        
        //jQuery('.ui-accordion-group').width('auto');
        
        //console.log(jQuery('.ui-accordion').width());
        
        
        //return;
            
        //jQuery('.ui-accordion-header').click(function(){
            
//            console.log(jQuery('.ui-accordion').width());
            //jQuery(this).parent().width(jQuery('.ui-accordion').width());
//            //jQuery('.ui-accordion-header').width('493px');
            //jQuery('.ui-state-default').width('493px');
//            jQuery('.ui-state-active').width(jQuery('.ui-accordion').width());
//            //.ui-state-active
//ui-accordion-header-collapsed ui-corner-all
//ui-accordion-header-active    ui-state-active
        //});
    });
    //return;
    
    //jQuery('table.accordion').accordion({header: '.category', autoHeight:false, fillSpace: true, collapsible:true, animate: 800 });// , active: 0, collapsible: false  active: 0,
    //jQuery('#placebilet').accordion({autoHeight:false,collapsible:true, active: 10});//,icons:{'header':'','headerSelected':''}
    //jQuery('.ui-accordion-content').hide(8000, function(){
        //alert("Wow");
    //    jQuery('#jshop').accordion({autoHeight:false,collapsible:true, active: 20});
    //}); 
    
    //jQuery('.ui-accordion-content').animate({height: 'hide'}, 8000, 'easeOutCirc');
    //jQuery('#jshop').accordion({autoHeight:false,collapsible:true, active: 20});
    // jQuery("#accordion1").accordion({autoHeight:false,event:"mouseover"});
    
    
});
