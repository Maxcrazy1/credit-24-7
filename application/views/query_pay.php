      <div class="content-wrapper">
        <section class="content-header">
          <h1>Créditos <small>Consulta por documento de identidad</small></h1>
        </section>
        <section class="content pt-50 pb-0">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtro de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form class="form" action="<?=_App_?>consulta/credito-usuario" method="POST">
                        <div class="form-group col-md-4">
                            <label for="fecha_inicial" class="control-label">Nro. de pasaporte o documento de identidad</label>
                            <input class="form-control" name="document-id" placeholder="Inserte su número de identidad">
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Consultar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
      </div>