<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script>
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript">
   $(document).ready(function (){
    var panels = $('.user-infos');
        var panelsButton = $('.dropdown-user');
        panels.hide();

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
     $("#file-3").fileinput({
//            url: (base_url + 'mnt_solicitudes/orden/nueva_orden_autor'),
            showUpload: false,
            language: 'es',
            showCaption: true,
            browseClass: "btn btn-warning btn-sm",
            allowedFileExtensions: ['png','jpg','gif'],
            maxImageWidth: 512,
            maxImageHeight: 512
        });
     $("[name='otro']").bootstrapSwitch();
    });
</script>
<style type="text/css">
 .modal-message .modal-header .fa, 
.modal-message .modal-header 
.glyphicon, .modal-message 
.modal-header .typcn, .modal-message .modal-header .wi {
    font-size: 30px;
}
</style>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right">
            <!--<i class="fa fa-desktop color"></i>--> 
            <img src="<?php echo base_url() ?>assets/img/tic/logo-dtic.png" class="img-rounded" alt="bordes redondeados" width="80" height="30">
            Solicitud
            <small> Genere una nueva solicitud</small></h2>
        <hr /> 
    </div>
    
    <!-- Page title -->
    <div class="row">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                    <div class="panel-heading">
                            <h3 class="panel-title text-center"><i class="color">*  Campos Obligatorios</i></h3>
                        </div>
                    <form class="form-horizontal" action="<?php echo base_url() ?>tic_solicitudes/solicitud" method="post" name="orden" id="orden" onsubmit="return validacion()" enctype="multipart/form-data">
                        
                        <div class="panel-body">
                            <h4 class="text-center">Dependencia: <i class="color"> <?php echo $nombre_depen; ?></i></h4>
                            <div class="form-group">
                                <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('nombre_contacto'); ?>
                                    <?php echo form_error('telefono_contacto'); ?>
                                    <?php echo form_error('asunto'); ?>
                                    <?php echo form_error('descripcion_general'); ?>
                                    <?php // echo form_error('observac'); ?>
                                    <?php echo form_error('oficina'); ?>
                                </div>
                                <div class="col-md-3 text-center">
                                    <label class="control-label"  for="nombre_contacto"><i class="color">*  </i>Contacto</label>
                                    <select class="form-control input-sm select2" id="nombre_contacto" name="nombre_contacto">
                                        <option></option>
                                        <option selected="<?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?>" value="<?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?>"><?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?></option>
                                        <?php
                                        foreach ($todos as $all):
                                            if (($this->session->userdata('user')['id_usuario']) != $all['id_usuario']):
                                                ?>
                                                <option value="<?php echo ucfirst($all['nombre']) . ' ' . ucfirst($all['apellido']) ?>"><?php echo ucfirst($all['nombre']) . ' ' . ucfirst($all['apellido']) ?></option>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                    <small><p>Persona de contacto</p></small>
                                </div>

                                <!-- TELEFONO CONTACTO -->
                                <!--<div class="col-md-1 text-center"></div>-->
                                <div class="col-md-2 text-center">
                                    <label class="control-label"  for="telefono_contacto">Teléfono</label>
                                    <input autocomplete="off" type="text" value="<?php echo ($this->session->userdata('user')['telefono']) ?>"
                                           style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control input-sm text-center" id="telefono_contacto" name="telefono_contacto"></input>
                                    <small><p>Teléfono de contacto</p></small>
                                </div>

                                <!-- ASUNTO -->
                                <div class="col-md-4 text-center">
                                    <label class="control-label" for="asunto"><i class="color">*  </i>Titulo:</label>
                                    <div class="from-group">
                                        <input type="text" autocomplete="off" onKeyDown=" contador(this.form.asunto, ($('#restan')), 25);" onKeyUp="contador(this.form.asunto, ($('#restan')), 25);" value="" title="No coloque caracteres especiales. Ejemplo: AIRE DAÑADO"
                                               style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control text-center input-sm" id="asunto" name="asunto" placeholder='Titulo de la solicitud'>
                                        <small><p align="right" name="resto" id="restan">0/25</p></small>
                                    </div>
                                </div>
                                <!--<div class="col-md-1"></div>-->

                                <!-- SELECT TIPO DE ORDEN -->
                                <div class="col-md-3 text-center">
                                    <label class="control-label" for = "id_tipo"><i class="color">*  </i>Tipo:</label>
                                    <!--<div class="col-lg-4">--> 
                                        <select class="form-control input-sm select2" id = "id_tipo" name="id_tipo">
                                            <option value=""></option>
                                            <?php foreach ($tipo as $ord): ?>
                                                <option value = "<?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <!--</div>-->
                                    <!--<div class="col-xs-6">-->
                                        <small><p>Tipo de Solicitud</p></small>
                                    <!--</div>-->
                                </div>

                                <!-- SELECT DE DEPENDENCIA-->
                                <div class="col-md-2 text-center">
                                    
                                </div>

                                <!-- SELECT DE UBICACION-->
                                <div class="col-md-4 text-center">
                                    <label class="control-label" for = "oficina"><i class="color">*  </i>Ubicación:<span class="label label-warning" data-toggle="modal" href="#ayuda2">?</span></label>
                                    <select class="form-control input-sm select2" id = "oficina_select" name="oficina_select">
                                            <option value="" class=""></option>
                                        <?php foreach ($ubica as $ubi): ?>
                                            <?php if ($id_depen == $ubi->id_dependencia):?>
                                                <option value = "<?php echo $ubi->id_ubicacion ?>"><?php echo $ubi->oficina ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                </select>
                                    </select>
                                </div>
                                <div class="col-md-4 text-center">
                                    <label class="control-label"> <!-- se habilita el checkbox cuando el select se deshabilita -->
                                        <input data-label-text="Otra ubicación" data-on-text="Si" data-off-text="No" data-off-color="info" data-size="mini" type="checkbox" name="otro" id="otro" value="opcion_1" onChange= "document.orden.oficina_select.disabled = !document.orden.oficina_select.disabled, document.orden.oficina_txt.disabled = !document.orden.oficina_txt.disabled">
                                    </label>
                                    
                                    <!-- NUEVA UBICACION -->

                                    <input type="text" autocomplete="off" class="form-control input-sm" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="oficina_txt" name="oficina_txt" disabled="true">                           

                                </div>
                                
                                <!-- DESCRIPCION-->
                                <div class="col-md-12 text-center">
                                    <label class="control-label " for="descripcion_general"><i class="color">*  </i>Detalles:<span class="label label-warning" data-toggle="modal" href="#ayuda">?</span></label>
                                    <textarea rows="5 autocomplete="off" type="text" title="No coloque caracteres especiales." onKeyDown=" contador(this.form.descripcion_general, ($('#resta')), 600);" onKeyUp="contador(this.form.descripcion_general, ($('#resta')), 600);"
                                              value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control text-center" id="descripcion_general" name="descripcion_general" placeholder='Detalles de la solicitud'></textarea>
                                
                                    <div class="col-sm-12 col-lg-12 text-right">
                                        <small><p name="resta" id="resta" size="4">0/600</p></small>
                                    </div>
                                </div>
                                 <!-- IMAGEN-->
                                <div class="col-md-12">
                                    <div class="col-xs-5"></div>
                                    <div class="row user-row">
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <strong>Añadir imagen</strong><br>
                                            <span class="text-muted"></span>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".uno">
                                            <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                                        </div>
                                    </div>
                                    <div class="row user-infos uno">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><br></div>
                                            <!--<div class=" col-md-12 col-lg-12">-->
                                            <!--                                            <label class="control-label col-sm-2">Selecciona una imagen</label>-->
                                            <div class="col-sm-4"></div>
                                            <div class="col-sm-5">
                                                <input id="file-3" name="archivo" type="file" multiple="true" data-show-caption="true"  class="file-loading">
                                            </div> 
                                            <div class="col-sm-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?php echo base_url() ?>tic_solicitudes/lista_solicitudes" class="btn btn-default">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>    
                </div>
            
        </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>