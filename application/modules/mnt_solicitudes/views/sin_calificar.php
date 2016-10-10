<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script><!-- Page content -->

<div class="mainy">
    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i>Solicitud <small></small></h2>
        <hr />
    </div>
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="jumbotron">
                    <div class="container">
                       
                        
                        <div class="alert alert-warning" role="alert"align="center"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i><p> Disculpe, usted debe <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/cerrada" class="alert-link">calificar</a> las solicitudes
                            cerradas antes de crear una nueva. </p>
                        </div>
                        <div align="center"><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/cerrada" class="btn btn-info">Calificar</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>