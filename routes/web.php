<?php

Route::get('/', function () {
    return view("welcome");
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');
//Route::post('registro','Usuarios@postRegistro')->name('registro_user');
Route::group(['middleware' => 'auth'], function() {//YOHAN MODULOS
    Route::get('uit', 'configuracion\Oficinas_Uit@get_alluit')->name('uit'); // tabla..
    Route::get('list_uit', 'configuracion\Oficinas_Uit@index'); // tabla grilla uit

    Route::post('uit_save', 'configuracion\Oficinas_Uit@insert'); // ruta para guardar
    Route::post('uit_mod', 'configuracion\Oficinas_Uit@modif');
    Route::post('uit_quitar', 'configuracion\Oficinas_Uit@eliminar');

    Route::get('oficinas', 'configuracion\Oficinas_Uit@get_alloficinas')->name('oficinas'); // tabla grilla Clientes
    Route::get('list_oficinas', 'configuracion\Oficinas_Uit@index1'); // tabla grilla uit
    Route::post('oficinas_mod', 'configuracion\Oficinas_Uit@modif_ofi');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/vw_general', 'General@index')->name('vw_general');

Route::get('msg', function() {
    return view('fnewUsuario');
});


Route::get('via', 'General@autocompletar_direccion');

//Route::get('/usuarios', function () {
//    return view("administracion/vw_usuarios");
//})->name('usuarios');



Route::group(['middleware' => 'auth'], function() {

    Route::get('list_usuarios', 'Usuarios@index'); // tabla grilla Usuarios
    Route::get('/usuarios', 'Usuarios@getAllUsuarios')->name('usuarios'); //vw_usuarios

    Route::post('usuario_save', 'Usuarios@insert_update_Usuarios');
    Route::post('usuario_delete', 'Usuarios@eliminar_usuario'); //eliminar usuario

    /*     * **************************AUTOLLENADO DE COMBOS********************************************************************* */
    Route::get('get_all_tipo_documento', 'General@get_tipo_doc'); //llena combo tipo documento
    Route::get('get_all_cond_exonerac', 'General@get_cond_exonerac'); //llena combo condicion exonerac
    Route::get('autocompletar_direccion', 'General@autocompletar_direccion'); //autocompleta el input text avenida,jiro, calle de contribuyentes
    Route::get('autocomplete_nom_via', 'configuracion\Valores_Arancelarios@get_autocomplete_nom_via'); //autocompletar arancel cod_via->nom_completo de via
    /*     * *******************DEPARTAMENTO  PROVINCIA DISTRITO  **************************************************************** */
    Route::get('get_all_dpto', 'General@get_dpto'); //llena combo departamentos
    Route::get('get_all_prov', 'General@get_prov'); //llena combo provincias
    Route::get('get_all_dist', 'General@get_dist'); //llena combo Distritos
    /*     * ********************************************************************************************************************* */
    /*     * **************************************CONTRIBUYENTES******************************************************************** */
    Route::get('contribuyentes', 'adm_tributaria\Contribuyentes@vw_contribuyentes')->name('adm_contribuyentes'); // VW_CONTRIUYENTES
    Route::get('grid_contribuyentes', 'adm_tributaria\Contribuyentes@index'); // tabla grilla Contribuyentes    
    Route::get('llenar_form_contribuyentes', 'adm_tributaria\Contribuyentes@llenar_form_contribuyentes'); //llena form contribuyentes
    Route::post('insert_new_contribuyente', 'adm_tributaria\Contribuyentes@insert_new_contribuyente');
    Route::post('contribuyente_update', 'adm_tributaria\Contribuyentes@modificar_contribuyente'); //update contribuyente
    Route::post('contribuyente_delete', 'adm_tributaria\Contribuyentes@eliminar_contribuyente'); //eliminar contribuyente

    /*     * ******************************************VALORES ARANCELARIOS******************************************************************** */
    Route::group(['namespace' => 'configuracion'], function() {
        Route::get('val_arancel', 'Valores_Arancelarios@vw_val_arancel')->name('val_aran'); // VW_ARANCELES
        Route::get('grid_val_arancel', 'Valores_Arancelarios@grid_valores_arancelarios'); // tabla grilla Valores Arancelarios
        Route::get('get_anio_val_arancel', 'Valores_Arancelarios@get_anio'); //llena combo AÑO vw_val_arancel
        Route::get('get_sector_val_arancel', 'Valores_Arancelarios@get_sector'); //llena combo SECTOR vw_val_arancel
        Route::get('get_mzna_val_arancel', 'Valores_Arancelarios@get_mzna'); //llena combo MANZANAvw_val_arancel        
        Route::post('insert_valor_arancel', 'Valores_Arancelarios@insert_valor_arancel');
        Route::post('update_valor_arancel', 'Valores_Arancelarios@update_valor_arancel');
        Route::post('delete_valor_arancel', 'Valores_Arancelarios@delete_valor_arancel');
    });

    /*     * ****************************************   VALORES UNITARIOS    ************************************************************** */

    Route::group(['namespace' => 'configuracion'], function() {
        Route::get('val_unit', 'Valores_Unitarios@show_vw_val_unit')->name('valores_unitarios'); // VW_VALORES_UNITARIOS
        Route::get('grid_val_unitarios', 'Valores_Unitarios@grid_val_unitarios'); // tabla grilla VALORES UNITARIOS
        Route::get('create_magic_grid_val_unit', 'Valores_Unitarios@magic_grid_valores_unit'); // EXECUTE FUNCTION POSTGRES... VALORES UNITARIOS
        Route::post('update_valor_unitario', 'Valores_Unitarios@update_valor_unitario');
    });

    Route::group(['namespace' => 'adm_tributaria'], function() {
        Route::resource('predios_urbanos', 'PredioController');
        Route::get('gridpredio','PredioController@listpredio');//llena combo MANZANAvw_val_arancel
        Route::get('selmzna','PredioController@ListManz');//llena combo MANZANAvw_val_arancel
        Route::get('getcontri','PredioController@GetContrib');//obtener informacion predio
    });

});




