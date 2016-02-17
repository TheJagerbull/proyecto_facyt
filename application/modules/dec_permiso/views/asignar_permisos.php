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
    
    function select_check(all,nombres){
        if(all.val() == 'select'){
            for (var i in nombres){
                nombres[i].checked = 'FALSE';
            }
            all.val('deselect'); 
        }else{
            for (var i in nombres){
                nombres[i].checked = '';
            }
            all.val('select');
        }
    }
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
                                                            <td><div align="center"><input type="checkbox" name="alm_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="alm_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="alm_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="alm_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="alm_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_1" value="select" onclick="select_check($('#checkAll_1'),document.getElementsByName('alm_ver[]'))"></div></td>
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
                                                                <td><div align="center"><input type="checkbox" name="alm_agregar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm_agregar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_2" value="select" onclick="select_check($('#checkAll_2'),document.getElementsByName('alm_agregar[]'))"></div></td>
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
                                                                <td><div align="center"><input type="checkbox" name="alm_generar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm_generar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_3" value="select" onclick="select_check($('#checkAll_3'),document.getElementsByName('alm_generar[]'))"></div></td>
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
                                                                <td><div align="center"><input type="checkbox" name="alm_editar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" name="alm_editar[]" value="1"></div></td>
                                                                <td><div align="center"><input type="checkbox" id="checkAll_4" value="select" onclick="select_check($('#checkAll_4'),document.getElementsByName('alm_editar[]'))"></div></td>
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
                                                               <td><div align="center"><input type="checkbox" name="alm_proceso[]" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" name="alm_proceso[]" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" name="alm_proceso[]" value="1"></div></td>
                                                               <td><div align="center"><input type="checkbox" id="checkAll_5" value="select" onclick="select_check($('#checkAll_5'),document.getElementsByName('alm_proceso[]'))"></div></td> 
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
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-table6">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th valign="middle"><div align="center">Solicitudes de dependencia</div></th>
                                                            <th valign="middle"><div align="center">Todas las solicitudes</div></th>
                                                            <th valign="middle"><div align="center">Solicitudes por estatus</div></th>
                                                            <th valign="middle"><div align="center">Solicitudes En Proceso</div></th>
                                                            <th valign="middle"><div align="center">Solicitudes Cerradas </div></th>
                                                            <th valign="middle"><div align="center">Todas </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <td><div align="center"><input type="checkbox" name="mantenimiento_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mantenimiento_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mantenimiento_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mantenimiento_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" name="mantenimiento_ver[]" value="1"></div></td>
                                                            <td><div align="center"><input type="checkbox" id="checkAll_3"></div></td>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-table7">
                                            hola2                                
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
 
