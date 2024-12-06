<div class="container">
    <h2>Gerenciamento dos Seeders das classes Entity</h2>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <th class="col-sm-6">Entity</th>
                <th class="col-sm-3">Opções</th>
            </thead>
            <tbody id='table-seeds'>
            </tbody>
        </table>
    </div>
</div>
<div id="modal-seeds-dados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Titulo Modal Seeds" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="modal-seeds-dados-title">Dados Que Serão Gerados</h4>
            </div>
            <div class="modal-body">
                <table id="tabela-registros" class="table table-striped table-hover table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
                <div class="text-center">
                    Disponível <i style='color: blue' class="glyphicon glyphicon-asterisk"></i> |
                    Gerado <i style='color: green' class="glyphicon glyphicon-ok"></i> |
                    Error <i style='color: red' class="glyphicon glyphicon-remove"></i> |
                    Dado Já Existe <i style='color: #ff973e' class="glyphicon glyphicon-info-sign"></i>
                </div>

                <div id="erros-seed">
                    <div id="erros-seed-body">
                    </div>
                </div>
                <div class="text-center" id='modal-body-footer'>
                    <button type="button" id='btn-seed' class="btn btn-success">Gerar Dados Da Entidade</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    const tableBody = document.querySelector("#table-seeds");
    const controllerUrl = udev.url.getUrlController();
    const seederEntity = udev.getVar('seeders');

    function buildTable() {
        tableBody.innerHTML = seederEntity.map((entity) => `
            <tr>
                <td>${entity}</td>
                <td>
                    <button class='btn btn-success' onclick="loadSeed('${entity}')">Povoar Tabela</button> - 
                    <button class='btn btn-danger' onclick="truncate('${entity}')">Truncate Tabela</button>
                </td>
            </tr>
        `).join('');
    }


    function loadSeed(entity) {
        $("#btn-seed").show();
        $("#erros-seed").hide();
        $("#erros-seed-body").html('');

        const table = document.querySelector('#tabela-registros');
        $("#btn-seed").one('click', () => seed(entity));

        $.get(`${controllerUrl}/loadSeeder?seederEntity=${entity}`, function(response) {
            const {
                data
            } = response;
            if (data.length !== 0) {
                table.querySelector('thead').innerHTML = `
                    <tr>
                        ${Object.keys(data[0]).map((columnName) => `<td>${columnName}</td>`).join('')}
                        <td>Result</td>
                    </tr>
                    `

                table.querySelector('tbody').innerHTML = `
                    ${data.map((row) => `
                            <tr> 
                                ${Object.keys(row).map(el => `<td>${row[el]}</td>`).join('')}
                                <td class='text-center' id='seed-${row['id']}'>
                                    <i style='color: blue' class="glyphicon glyphicon-asterisk"></i>
                                </td>
                            </tr>

                    `).join('')}
                `;
            } else {
                table.innerHTML = "<h3 class='text-center'>Nenhum Registro Para Gravar No Banco de Dados</h3>";
                $("#btn-seed").hide();
            }

            $('#modal-seeds-dados-title').text('Dados Que Serão Gerados - ' + entity);
            $("#modal-seeds-dados").modal();
        });
    }

    function seed(entity) {
        $("#btn-seed").hide();
        const modalBodyFooter = $('#modal-modal-body-footer');
        const url = `${controllerUrl}/seed?seederEntity=${entity}`;

        $.get(url, function({
            result,
            data
        }) {
            const {
                dadosGerados,
                erros,
                jaExiste
            } = data;
            for (dado of dadosGerados) {
                $(`#seed-${dado['id']}`).html(`<i style='color: green' class="glyphicon glyphicon-ok"></i>`);
            }

            for (dado of erros) {
                $(`#seed-${dado['id']}`).html(`<i style='color: red' class="glyphicon glyphicon-remove"></i>`);
            }
            if (erros.length != 0) {
                $("#erros-seed").show();
                const body = $("#erros-seed-body");

                $('#erros-seed-body').html(`
                    <h3>Erros</h3>
                    <ul>
                        ${erros.map(erro => `<li>id=${erro.id} -> ${erro.message};</li>`).join('')}
                    </ul>
                `);
            }

            for (dado of jaExiste) {
                $(`#seed-${dado['id']}`).html(`<i style='color: #ff973e' class="glyphicon glyphicon-info-sign"></i>`);
            }

        });
    }

    function truncate(entity) {

        if (confirm("Tem certeza que deseja remover todos os registros de " + entity + "?"))
            $.get(`${controllerUrl}/truncate?seederEntity=${entity}`, function(response) {
                const {
                    result,
                    code,
                    msg
                } = response;
                if (result === 'success') {
                    alert(msg);
                } else {
                    alert(`Error: ${msg}`);
                }
            });
    }

    $(document).ready(function() {
        buildTable();
    });
</script>
