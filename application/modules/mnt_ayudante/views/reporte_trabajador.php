<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function() {
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
    });
</script>

<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-user color"></i> Reportes por trabajador<small> Seleccione ver detalles</small></h2> 
        <hr />
    </div>
<!--    <nav class="navbar navbar-default">
        <div class="container-fluid">
             Brand and toggle get grouped for better mobile display 
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><span class="glyphicon glyphicon-cog"></span></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/listar">Listar <span class="sr-only">(current)</span></a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar" id="buscador">
                    </div>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </form>
                <ul class="nav navbar-form navbar-right">
                    <a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/crear" class="btn btn-success" data-toggle="modal">Agregar</a>
                </ul>

            </div> /.navbar-collapse 
        </div> /.container-fluid 
    </nav>-->

    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                </div>
                <?php if ($this->session->flashdata('create_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla creada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla modificada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla eliminada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_item') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema eliminando la cuadrilla</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_item') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la cuadrilla</div>
                <?php endif ?>

                <div class="awidget-body">
                    <div class="row">
                        <div class="col-md-10 col-sm-10">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <label><strong></strong> </label>
                                    <div class="btn-group btn-group-sm pull-right">
                                        <label><strong></strong></strong> </label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div align='center'><strong></strong></div>                   
                                    <div well class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información del contacto</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".uno">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos uno">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información de la solicitud</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".dos">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos dos">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>    
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Estatus</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".tres">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos tres">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                    
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>                          
                                <div class="panel-footer">
                                    <div class='container'align="right">
                                        <div class="btn-group btn-group-sm pull-right">
                                            <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                                            <!--<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button> -->
                                            <a data-toggle="modal" data-target="#pdf" class="btn btn-default btn">Crear PDF</a> 
                                                   
                                        </div>
                                    </div>  
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>