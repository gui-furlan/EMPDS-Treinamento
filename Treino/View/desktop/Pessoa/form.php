<div class="container form-container">
  <div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 id="formTitle"></h3>
      </div>
      <div class="panel-body">
        <form id="form" class="form-horizontal" method="post">
          <input data-track="id" type="hidden" id="id" name="id" />
          <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Nome:</label>
            <div class="col-sm-8">
              <input class="form-control nomeField" name="nome" id="nome" maxlength="150" />
            </div>
          </div>
          <div class="form-group">
            <label for="cpf" class="col-sm-2 control-label">Cpf:</label>
            <div class="col-sm-4">
              <input class="form-control" name="cpf" id="cpf" maxlength="11" />
            </div>
            <label for="idade" class="col-sm-2 control-label">Idade:</label>
            <div class="col-sm-2">
              <input class="form-control" name="idade" id="idade" maxlength="3" />
            </div>
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-8 action-container"></div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<div class="barra-msg">
  <div class="barra-msg-conteudo">
    <div id="msg" class="div-msg"></div>
  </div>
</div>
</div>

<script src="/libs/BaseEmpds/scripts/tela.js"></script>
<script src="/libs/BaseEmpds/scripts/formulario.js"></script>
<script>
  $(document).ready(() => {
    const formularioJS = new FormularioPadrao()

    formularioJS.setOption('tituloInsert', "Registro de Pessoas");
    formularioJS.setOption('tituloUpdate', "Edição de Pessoas");
    //usado para atualizar e manter na mesma página
    // formularioJS.setOption("redirectConsultaSubmit", false);
    formularioJS.addDefaultActions();

    formularioJS.iniciaFormulario();
  });
</script> 