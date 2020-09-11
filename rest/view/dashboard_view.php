<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<h1>ComparaHosting Admin Panel</h1>


<div class="admin_manage_panel">
    <ul class="tabs">
        <li  rel="tab1" class="active"><span class="dashicons dashicons-randomize"></span>Importar Data</li>
        <li rel="tab2"><span class="dashicons dashicons-admin-page"></span>Configurar Cupones</li>
        <li rel="tab3" ><span class="dashicons dashicons-admin-page"></span>Opciones de Filtros</li>
    </ul>


    <div class="tab_container">

        <!-- #tab 1 -->
        <h3 class="d_active tab_drawer_heading" rel="tab1">Data Get</h3>
        <div id="tab1" class="tab_content">
            <?php include "get_data_tab.php"; ?>
        </div>
        <!-- #tab1 -->


        <!-- #tab 2 -->
        <h3 class="tab_drawer_heading" rel="tab2">Tab 2</h3>
        <div id="tab2" class="tab_content">
            <?php include "manage_cupon.php"; ?>
        </div>
        <!-- #tab2 -->

		 <!-- #tab 3 -->
		 <h3 class="tab_drawer_heading" rel="tab3">Tab 2</h3>
        <div id="tab3" class="tab_content">
			<?php include "filter-view.php"; ?>
        </div>
        <!-- #tab3 -->

    </div>

    <!-- .tab_container -->
</div>


<Style>

.admin_manage_panel{
    width: 98%;
    display: block;
    /* justify-content: center;
    align-content: center;
    text-align: center; */
}
    
ul.tabs {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 32px;
	border-bottom: 2px solid #d8d8d8;
	width: 100%;
}

ul.tabs li {
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
	float: left;
	margin: 0;
	cursor: pointer;
	padding: 0px 21px;
	height: 31px;
	line-height: 31px;
	border-top: 2px solid rgba(151, 89, 151, 0.5);
	border-left: 2px solid #d8d8d8;
	border-bottom: 1px solid #d8d8d8;
	background-color: #FFF;
	color: #000;
	overflow: hidden;
	position: relative;
}

.tab_last { border-right: 2px solid #d8d8d8; }

ul.tabs li:hover {
	color: #975997;
}

ul.tabs li.active {
	background-color: #fff;
	color: #975997;
	border-bottom: 1px solid #fff;
    border-top: 2px solid rgba(151, 89, 151, 1);
	display: flex;
}

.tab_container {
	border: 2px solid #d8d8d8;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
	border-top: none;
	clear: both;
	float: left;
	width: 100%;
	background: #fff;
	overflow: auto;
}

.tab_content {
	padding: 20px;
	display: none;
}

.tab_drawer_heading { display: none; }

@media screen and (max-width: 480px) {
	.tabs {
		display: none;
	}
	.tab_drawer_heading {
		background-color: #ccc;
		color: #fff;
		border-top: 1px solid #333;
		margin: 0;
		padding: 5px 20px;
		display: block;
		cursor: pointer;
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	.d_active {
		background-color: #666;
		color: #fff;
	}
}

</Style>



<Script>

    jQuery(".tab_content").hide();
    jQuery(".tab_content:first").show();

  /* if in tab mode */
    jQuery("ul.tabs li").click(function() {
		
      jQuery(".tab_content").hide();
      var activeTab = jQuery(this).attr("rel"); 
      jQuery("#"+activeTab).fadeIn();		
		
      jQuery("ul.tabs li").removeClass("active");
      jQuery(this).addClass("active");

	  jQuery(".tab_drawer_heading").removeClass("d_active");
	  jQuery(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
	  
    });

	/* if in drawer mode */
	jQuery(".tab_drawer_heading").click(function() {
      
      jQuery(".tab_content").hide();
      var d_activeTab = jQuery(this).attr("rel"); 
      jQuery("#"+d_activeTab).fadeIn();
	  
	  jQuery(".tab_drawer_heading").removeClass("d_active");
      jQuery(this).addClass("d_active");
	  
	  jQuery("ul.tabs li").removeClass("active");
	  jQuery("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });
	
	
	/* Extra class "tab_last" 
	   to add border to right side
	   of last tab */
	jQuery('ul.tabs li').last().addClass("tab_last");
	
	jQuery( document ).ready(function() {
		jQuery(".js-filter-clasic").select2({
  width: '30%'
	});


	jQuery(".js-filter-clasic-delete").select2({
  width: '30%'
	});
});


</Script>
