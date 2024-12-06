<div class="container form-container">
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 id="formTitle"></h3>
            </div>
            <div class="panel-body">
                <form id="form" class="form-horizontal" method="post">
                    <input data-track="id" type="hidden" id="id" name="id" />
                    <input data-track="membro" type="hidden" id="membro" name="membro">
                    <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome:</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="nome" id="nome" maxlength="150" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="col-sm-2 control-label">Descrição:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descricao" id="descricao" maxlength="255" rows="3" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formMembro" class="col-sm-2 control-label">Membro:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="formMembro" id="formMembro" disabled />
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
        const membro = udev.getVar('membro');

        formularioJS.setOption('tituloInsert', "Registro de Tarefas");
        formularioJS.setOption('tituloUpdate', "Edição de Tarefas");
        //usado para atualizar e manter na mesma página
        // formularioJS.setOption("redirectConsultaSubmit", false);
        //assim q debuga para ir pro front, então pegamos e vamos no noetwork
        //formularioJS.setOption('redirectConsultaSubmit', false);
        formularioJS.setUrlRedirectConsulta(`${udev.url.getUrlModule()}/Membro/index/?equipe=${membro.equipe.id}`)
        formularioJS.addDefaultActions();
        formularioJS.iniciaFormulario();
        
        $('#formMembro').val(membro.pessoa.nome);
        $('#membro').val(membro.id);
    });
</script>