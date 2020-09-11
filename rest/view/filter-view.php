<?php
   /// catalogo de filtros 
   $filter_catalogo = get_option('filtros_hosting_data'); 
   $cat_filter = [];

   if(isset($_POST['borrar_cat_filter'])){
    $key = array_search($_POST['delete-cat'], array_column(get_option('catalogos_hosting_data'), 'name_cat'));
    $old = get_option('catalogos_hosting_data');

   unset($old[$key]);
   update_option('catalogos_hosting_data',array_values($old));
   
}

   if(isset($_POST['filter_cat'])){

    if(!is_array(get_option('catalogos_hosting_data'))){
        update_option('catalogos_hosting_data', array());
    }
    $filter_save= get_option('catalogos_hosting_data'); 

    $namecat = $_POST['namecat'];
    $listfilter = $_POST['list-filter'];
    $urlimg = $_POST['imgcat'];

    $array = array(
       'name_cat'  =>  $namecat,
       'in_cat'    => $listfilter,
       'img'    => $urlimg,
       'count'    => count($listfilter)
    );
    
    array_push($filter_save,$array );

    update_option('catalogos_hosting_data', $filter_save);
   }
    $filter_save= get_option('catalogos_hosting_data'); 

    foreach($filter_save as $key => $pa){
        $cat_filter[] = $pa['name_cat'];
        
        foreach($pa['in_cat'] as $pe){
            $clave = array_search($pe, $filter_catalogo);
            unset($filter_catalogo[$clave]);
        }
    }
  
 
?>
<h2>Categorias Actuales</h2>
<form  method= 'POST' >
<p>
    <label>Nombre de categoria : </label><br>
    <input type='text' name='namecat' size='57.8px' />
</p>
<p>
    <label>Seleccione los filtros para esta categoria :</label><br>
    <select name='list-filter[]' multiple class='js-filter-clasic'> 
       <?php 
        foreach($filter_catalogo as $po){ ?>
            <option value='<?php echo $po; ?>'><?php echo $po; ?></option>
        <?php } ?>
    </select>
</p>
<p>
<label>Ingrese la url de la imagen para esta categoria :</label><br>
<input type='url' name='imgcat' size='57.8px'>
</p>
<input type='submit' name='filter_cat' value='Guardar'>
</form>

<h2>Borrar Categoria</h2>
<p>
<form  method= 'POST' >
<select name='delete-cat' class='js-filter-clasic-delete'>
<?php 
    foreach($cat_filter as $pa){
?>
    <option value='<?php echo $pa; ?>'><?php echo $pa; ?></option>
<?php
    }
?>
</select><br>
<p>
<input type='submit' value='Borrar' name='borrar_cat_filter'>
</p>
</form>
<p>