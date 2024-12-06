<div class="container form-container">
  <div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 id="formTitle"></h3>
      </div>
      <div class="panel-body">
        <form id="form" class="form-horizontal" method="post">
          <input data-track="id" type="hidden" id="id" name="id" />
          <input data-track="equipe" type="hidden" id="equipe" name="equipe" />
          <input data-track="pessoa" type="hidden" id="pessoa" name="pessoa" />
          <div class="form-group">
            <label for="formMontarEquipe" class="col-sm-2 control-label">Equipe:</label>
            <div class="col-sm-6">
              <input class="form-control" name="formMontarEquipe" id="formMontarEquipe" disabled />
            </div>
          </div>
          <div class="form-group">
            <label for="formPessoa" class="col-sm-2 control-label">Pessoa:</label>
            <div class="col-sm-6">
              <select class="form-control" name="formPessoa" id="formPessoa"></select>
            </div>
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-8 action-container"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="barra-msg">
  <div class="barra-msg-conteudo">
    <div id="msg" class="div-msg"></div>
  </div>
</div>

<script src="/libs/BaseEmpds/scripts/tela.js"></script>
<script src="/libs/BaseEmpds/scripts/formulario.js"></script>
<script>
  $(document).ready(() => {
    const formularioJS = new FormularioPadrao();
    const equipe = udev.getVar("equipe");


    formularioJS.setOption('tituloInsert', "Adição de Membro em Equipes");
    formularioJS.setOption('tituloUpdate', "Edição de Membros em Equipes");


    formularioJS.addDefaultActions();
    formularioJS.setUrlRedirectConsulta(`${udev.url.getUrlController()}/index/?equipe=${equipe.id}`);

    formularioJS.iniciaFormulario();

    const equipes = `${equipe.nome} (${equipe.sigla})`;
    $('#formMontarEquipe').val(equipes);
    $('#equipe').val(equipe.id);

    //Ter a opção de dropDown e posteriormente a adição de busca pelo cpf
    listaPessoas();

    function listaPessoas() {
      $.ajax({
        url: `${udev.url.getUrlModule()}/Pessoa/getAll`,
        method: 'GET',
        success: function ({ data }) {
          $('#formPessoa').empty();

          data.forEach(function (pessoa) {
            $('#formPessoa').append(`<option value="${pessoa.id}">${pessoa.nome}</option>`);
          });
          //para caso não esteja selecionando ninguém, será selecionado a posição 0 do array
          if (data[0].id != null) {
            $('#pessoa').val(data[0].id);
          }
        },
        error: function (xhr, status, error) {
          console.error(error);

        }
      });
    };

    $('#formPessoa').change(function ({ currentTarget }) {
      let idPessoa = $(currentTarget).val();
      $('#pessoa').val(idPessoa);

    });
  });
</script>