<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<div class="mainy">
  
  <!-- Page title -->
  <div class="page-title">
    <!-- <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2> -->
    <h2 align="right"><img src="<?php echo base_url() ?>assets/img/alm/main.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"> Articulos <small>de almacen</small></h2>
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">   
    <div class="awidget full-width">
        <div class="awidget-head">
              <h3>Operaciones sobre inventario de almacen</h3>
              <!-- <button id="mail" align="right">enviar retroalimentaci&oacute;n</button> -->
        </div>
            <?php if($this->session->flashdata('add_articulos') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando art&iacute;culos desde el archivo</div>
            <?php endif ?>
            <?php if($this->session->flashdata('add_articulos') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Art&iacute;culos agregados exitosamente</div>
            <?php endif ?>
        <div class="awidget-body">
            <ul id="myTab" class="nav nav-tabs">
              <!-- <?php if(!empty($alm[1])):?><li class="active"><a href="#home" data-toggle="tab">Cat&aacute;logo</a></li><?php endif;?> -->
              <!-- <?php if(!empty($alm[4])):?><li><a href="#active" data-toggle="tab">Inventario</a></li><?php endif;?> -->
              <!-- <?php if(!empty($alm[6])||!empty($alm[7])):?><li><a href="#add" data-toggle="tab">Agregar articulos</a></li><?php endif;?> -->
              <?php if(!empty($alm[5])):?><li class="active"><a href="#rep" data-toggle="tab">Reportes</a></li><?php endif;?>
              <!-- <?php if(!empty($alm[8])):?><li><a href="#close" data-toggle="tab">Cierre</a></li><?php endif;?> -->
            </ul>
          <div id="myTabContent" class="tab-content">


<!--LA ALTERACION SOBRE "principal.php"-->
          <?php if(!empty($alm[5])):?>
            <div id="rep" class="tab-pane fade in active">
                              <!-- Cuerpo del tab-->
                              <div class="awidget-body">
                                  <div class="container">
                                        <div id="nrColumns" class="col-lg-12 col-md-12 col-sm-12 col-xm-12 dropdown" align="center">
                                          <!-- <div class="dropdown"> -->
                                              <button class="btn btn-primary dropdown-toggle" id="selectNrColumns" type="button" data-toggle="dropdown">Elija la cantidad de columnas
                                              <span class="caret"></span></button>
                                              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="right: 50%; left: 37%;">
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(2)" role="menuitem" tabindex="-1">2 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(3)" role="menuitem" tabindex="-1">3 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(4)" role="menuitem" tabindex="-1">4 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(5)" role="menuitem" tabindex="-1">5 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(6)" role="menuitem" tabindex="-1">6 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(7)" role="menuitem" tabindex="-1">7 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(8)" role="menuitem" tabindex="-1">8 columnas</a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" role="menuitem" tabindex="-1">About Us</a></li>    
                                              </ul>
                                          <!-- </div> -->
                                        </div>
                                        <div id="columns" hidden class="col-lg-12 col-md-12 col-sm-12 col-xm-12" align="center">
                                        </div>
                                        <div id="preview" class="col-lg-12 col-md-12 col-sm-12 col-xm-12" align="center">
                                        </div>



                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xm-4" align="center">
                                          <label class="control-label" for="reporteIn" id="reporte_label">Estado de inventario</label>
                                          <div id="reporteIn" class="input-group" >
                                            <button class="btn btn-block btn-lg btn-info addon" data-toggle="modal" data-target="#reporte" id="reportePdf">  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button>
                                          </div>
                                        </div>
                                        
                                  </div>
                              </div>
                              <!-- Fin del cuerpo del tab-->
              <!-- Modal para cierre de inventario -->
                              <div class="modal fade" id="cierre_inventario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title">Cierre de inventario</h4>
                                    </div>
                                    <div class="modal-body">
                                              <div class="alert alert-warning" style="text-align: center">
                                                Para realizar el cierre de inventario, debe cargar un archivo del inventario tangible con el siguiente formato...
                                              </div>
                                        <!-- Subida de archivo de excel para cierre de inventario-->
                                              <!-- <div class="form-group">
                                                  <label class="control-label" for="excel">Insertar archivo de Excel:</label>
                                                  <div class="input-group col-md-5">
                                                      <input id="excel" type="file" name="userfile">
                                                  </div>
                                              </div> -->
                                        <!-- FIN DE Subida de archivo de excel para cierre de inventario-->
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
              <!-- /.find del modal -->
              <!-- Modal para consultar el formato del documento -->
                              <div class="modal fade" id="formato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title">Formato de la tabla de inventario</h4>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
              <!-- /.find del modal -->
            </div>
          <?php endif;?>
<!--FIN DE LA ALTERACION SOBRE "principal.php"-->

          </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function selectedColumns(numberOfColumns)
  {
    console.log(numberOfColumns+" columnas selecciondas");
    var size = Math.round(12/numberOfColumns);

    console.log(size);
    $("#columns").html('');
    $("#columns").append('<div>');
    for (var i = 0; i < numberOfColumns; i++)
    {
      $("#columns").append('<div class="col-lg-'+size+' col-md-'+size+' col-sm-'+size+' col-xm-'+size+'">input'+(i+1)+' </div>');
    }
    $("#columns").append('</div>');
      $("#columns").show();

  }
  $(function(){
        $(".select2, .select2-multiple").select2({//Esto es para iniciar el select2 como clase, ejemplo en la clase del select:
             theme: "bootstrap",
             language: "es",
            placeholder: "--SELECCIONE--", // <input select = "nombre select" class =" Le agregas clase de boostrap y luego la terminas con clase2 para activarlo" 
            allowClear: true
           });

    //permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes

        $("#dependencia_select").change(function () {//Evalua el cambio en el valor del select
            $("#dependencia_select option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                var departamento = $('#dependencia_select').val();  //este valor se le asigna a una variable
                $.post(base_url + "index.php/mnt_solicitudes/orden/select_oficina", { //se le envia la data por post al controlador respectivo
                    departamento: departamento  //variable a enviar
                }, function (data) { //aqui se evalua lo que retorna el post para procesarlo dependiendo de lo que se necesite
                    $("#oficina_select").html(data); //aqui regreso las opciones del select dependiente 
                });
            });
        });
////menu de columnas para generar el reporte
    // $(".dropdown").on("show.bs.dropdown", function(event){
    //     var x = $(event.relatedTarget).text(); // Toma el texto del elemento seleccionado
    //     alert(x);
    // });
////FIN del menu de columnas para generar el reporte

    $('#reportePdf').click(function(){
      var hoy = new Date();
        $('#reporte_pdf').attr("src", "<?php echo base_url() ?>index.php/inventario/reporte");
    });
  });
</script>