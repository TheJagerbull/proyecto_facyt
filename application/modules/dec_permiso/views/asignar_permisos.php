<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function() {
        var panels = $('.user-infos');
        var panelsButton = $('.dropdown-user');
        panels.show();

        //Click dropdown
        panelsButton.click(function() {
        //get data-for attribute
            var dataFor = $(this).attr('data-for');
            var idFor = $(dataFor);

        //current button
            var currentButton = $(this);
            idFor.slideToggle(400, function() {
            //Completed slidetoggle
                if(idFor.is(':visible'))
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                }
                else
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                }
            })
        });
        $('[data-toggle="tooltip"]').tooltip();
});

//    function select_check(all,nombres){
//        if(all.val() == 'select'){
//            for (var i in nombres){
//                nombres[i].checked = 'FALSE';
//            }
//            all.val('deselect'); 
//        }else{
//            for (var i in nombres){
//                nombres[i].checked = '';
//            }
//            all.val('select');
//        }
//    }
    function diferent(nombre){
        var chkBoxes = $("input[id^="+nombre+"]");
        chkBoxes.prop("checked", !chkBoxes.prop("checked"));
    };
</script>
<!-- Page content -->

<div class="mainy">
<!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-users color"></i> Control de acceso <small>Seleccione para asignar  </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <!--<div class="row">-->
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label"><?php echo $title?></label>
           
            </div>
            <!--<div class="panel-body">-->
<!--                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table id="usuarios" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                        <thead>
                            <tr>
                                <th colspan="14" valign="middle"><div align="center">Almacén</div></th>
                                    
                            </tr>
                            <tr>
                                <th colspan="5" valign="middle"><div align="center">Ver</div></th>
                                <th colspan="2" valign="middle"><div align="center">Agregar</div></th>
                                <th colspan="2" valign="middle"><div align="center">Generar</div></th>
                                <th colspan="2" valign="middle"><div align="center">Editar</div></th>
                                <th colspan="3" valign="middle"><div align="center">Procesos</div></th>
                            </tr>
                            <tr>
                                <th valign="middle"><div align="center">Catálogo</div></th>
                                <th valign="middle"><div align="center">Solicitud</div></th>
                                <th valign="middle"><div align="center">Solicitud de departamento</div></th>
                                <th valign="middle"><div align="center">Inventario</div></th>
                                <th valign="middle"><div align="center">Historial / Reportes </div></th>
                                <th valign="middle"><div align="center">Inventario</div></th>
                                <th valign="middle"><div align="center">Por archivo</div></th>
                                <th valign="middle"><div align="center">Cierre Inventario</div></th>
                                <th valign="middle"><div align="center">Solicitud</div></th>
                                <th valign="middle"><div align="center">Articulo</div></th>
                                <th valign="middle"><div align="center">Solicitud</div></th>
                                <th valign="middle"><div align="center">Aprobar solicitud</div></th>
                                <th valign="middle"><div align="center">Despachar solicitud</div></th>
                                <th valign="middle"><div align="center">Enviar solicitud</div></th>
                            </tr>
                        </thead>
                        <tbody>
                             <tr>
                                <td>Almacén</td>
                            </tr>
                            <tr>
                                <td>Mantenimiento</td>
                            </tr>
                            <tr>
                                <td>Mantenimiento de aires</td>
                            </tr>
                            <tr>
                                <td>Usuarios</td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>-->
            <form class="form" action="<?php echo base_url() ?>index.php/dec_permiso/dec_permiso/asignar_permiso" method="post" name="permiso" id="permiso">   
                <input type="hidden" name="id_usuario" value="<?php echo $id ?>">
                <div class="panel-body">
                    <div well class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div><strong>Almacen</strong></div>          
                        <div class="row user-row">
                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                <strong></strong><br>
                                <span class="text-muted"></span>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".uno">
                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                            </div>
                        </div>
                        <div class="row user-infos uno">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class=" col-md-12 col-lg-12">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="active">
                                                <a href="#tab-table1" data-toggle="tab">Ver</a>
                                            </li>
                                            <li>
                                                <a href="#tab-table2" data-toggle="tab">Agregar</a>
                                            </li>
                                            <li>
                                                <a href="#tab-table3" data-toggle="tab">Generar</a>
                                            </li>
                                            <li>
                                                <a href="#tab-table4" data-toggle="tab">Editar</a>
                                            </li>
                                            <li>
                                                <a href="#tab-table5" data-toggle="tab">Procesos</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-table1">
                                                <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th valign="middle"><div align="center">Catálogo</div></th>
                                                                <th valign="middle"><div align="center">Solicitud</div></th>
                                                                <th valign="middle"><div align="center">Solicitud de departamento</div></th>
                                                                <th valign="middle"><div align="center">Inventario</div></th>
                                                                <th valign="middle"><div align="center">Historial / Reportes </div></th>
                                                                <th valign="middle"><div align="center">Todos</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td><div align="center"><input type="checkbox"  name="alm[1]" id="ver1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox"  name="alm[2]" id="ver2"  value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox"  name="alm[3]" id="ver3" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox"  name="alm[4]" id="ver4" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox"  name="alm[5]" id="ver5"  value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_1" onclick="diferent('ver')"></div></td>
                                                        </tbody>
                        
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab-table2">
                                                <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th valign="middle"><div align="center">Inventario</div></th>
                                                                <th valign="middle"><div align="center">Por archivo</div></th>
                                                                <th valign="middle"><div align="center">Todos</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <td><div align="center"><input type="checkbox" name="alm[6]" id="agregar1" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm[7]" id="agregar2" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_2" value="select" onclick="diferent('agregar')"></div></td>
                                                        </tbody>
                        
                                                    </table>                               
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab-table3">
                                                <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th valign="middle"><div align="center">Cierre Inventario</div></th>
                                                                <th valign="middle"><div align="center">Solicitud</div></th>
                                                                <th valign="middle"><div align="center">Todos</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <td><div align="center"><input type="checkbox" name="alm[8]" id="generar1" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm[9]" id="generar2" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_3" value="select" onclick="diferent('generar')"></div></td>
                                                        </tbody>
                        
                                                    </table>                               
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab-table4">
                                                <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                        <thead>
                                                            <tr>
                                                               <th valign="middle"><div align="center">Articulo</div></th>
                                                               <th valign="middle"><div align="center">Solicitud</div></th>
                                                               <th valign="middle"><div align="center">Todos</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <td><div align="center"><input type="checkbox" name="alm[10]" id="editar1" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm[11]" id="editar2" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_4" value="select" onclick="diferent('editar')"></div></td>
                                                        </tbody>
                        
                                                    </table>                               
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab-table5">
                                                <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                        <thead>
                                                            <tr>
                                                               <th valign="middle"><div align="center">Aprobar solicitud</div></th>
                                                               <th valign="middle"><div align="center">Despachar solicitud</div></th>
                                                               <th valign="middle"><div align="center">Enviar solicitud</div></th>
                                                               <th valign="middle"><div align="center">Todos</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <td><div align="center"><input type="checkbox" name="alm[12]" id="proceso1" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" name="alm[13]" id="proceso2" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" name="alm[14]" id="proceso3" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" id="checkAll_5" value="select" onclick="diferent('proceso')"></div></td> 
                                                        </tbody>
                        
                                                    </table>                               
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row user-row">
                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                <strong>Mantenimiento</strong><br>
                                    <span class="text-muted"></span>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".dos">
                                    <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                </div>
                        </div>
                        <div class="row user-infos dos">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class=" col-md-12 col-lg-12">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active">
                                            <a href="#tab-table6" data-toggle="tab">Ver</a>
                                        </li>
                                        <li>
                                            <a href="#tab-table7" data-toggle="tab">Agregar</a>
                                        </li>
                                        <li>
                                            <a href="#tab-table8" data-toggle="tab">Crear</a>
                                        </li>
                                        <li>
                                            <a href="#tab-table9" data-toggle="tab">Editar</a>
                                        </li>
                                        <li>
                                            <a href="#tab-table10" data-toggle="tab">Procesos</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-table6">
                                             <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="9" valign="middle"><div align="center">Solicitudes</div></th>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Todas</div></th>
                                                            <th valign="middle"><div align="center">Dependencia</div></th>
                                                            <th valign="middle"><div align="center">Estatus</div></th>
                                                            <th valign="middle"><div align="center">En Proceso</div></th>
                                                            <th valign="middle"><div align="center">Cerradas/anuladas</div></th>
                                                            <th valign="middle"><div align="center">Detalle dep.</div></th>
                                                            <th valign="middle"><div align="center">Detalle Adm.</div></th>
                                                            <th valign="middle"><div align="center">Asignación</div></th>
                                                            <th valign="middle"><div align="center">Todo</div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mnt[1]" id="mnt_ver1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[2]" id="mnt_ver2" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[3]" id="mnt_ver3" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[4]" id="mnt_ver4" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[5]" id="mnt_ver5" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[6]" id="mnt_ver6" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[7]" id="mnt_ver7" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[8]" id="mnt_ver8" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_6" onclick="diferent('mnt_ver')"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-table7">
                                            <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Cuadrilla</div></th>
                                                            <th valign="middle"><div align="center">Ubicación</div></th>
                                                            <th valign="middle"><div align="center">Todo</div></th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mnt[9]" id="mnt_agregar1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[10]" id="mnt_agregar2" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_7" onclick="diferent('mnt_agregar')"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-table8">
                                            <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Solicitudes</div></th>
                                                            <th valign="middle"><div align="center">Solicitudes por departamento</div></th>
                                                            <th valign="middle"><div align="center">Todo</div></th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mnt[11]" id="mnt_crear1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[12]" id="mnt_crear2" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_8" onclick="diferent('mnt_crear')"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-table9">
                                            <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Solicitudes abiertas</div></th>
                                                            <th valign="middle"><div align="center">Estatus solicitud</div></th>
                                                            <th valign="middle"><div align="center">Cuadrillas</div></th>
                                                            <th valign="middle"><div align="center">Todo</div></th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mnt[13]" id="mnt_editar1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[14]" id="mnt_editar2" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[15]" id="mnt_editar3" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_9" onclick="diferent('mnt_editar')"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-table10">
                                            <div class="col-lg-12 col-md-12 col-sm-12"><br></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Asignar personal</div></th>
                                                            <th valign="middle"><div align="center">Elimnar miembros de cuadrilla</div></th>
                                                            <th valign="middle"><div align="center">Todo</div></th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mnt[16]" id="mnt_proceso1" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mnt[17]" id="mnt_proceso2" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_10" onclick="diferent('mnt_proceso')"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                </div>
              
            </div>
            <div class="panel-footer">
                <div class='container'align="right">
                    <div class="btn-group btn-group-sm pull-right">
                        <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>  
            </div>
        </form>
        </div>
</div>    
 
