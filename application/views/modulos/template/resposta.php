<section class="content-header">
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
        <div class="col-md-6">
              <div class="box box-default">
                <div class="box-header with-border">
                  <i class="fa fa-bullhorn"></i>
                  <h3 class="box-title">Mensagem</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="callout callout<?php if (!empty($class)) echo $class?>">
                    <h4><?php if (!empty($titulo)) echo $titulo ?></h4>
                    <p><?php if (!empty($mensagem)) echo $mensagem ?></p>
                    <a href="<?php if (!empty($retorno)) echo $retorno ?>" role="button" class="block-tela btn btn<?php if (!empty($class)) echo $class?>"><i class="fa fa-rotate-left"></i>&nbsp;&nbsp;Voltar</a>
                  </div>
                  
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div> <!-- /.row -->
</section>