<div class="container">
    <h2>Testes dos Controllers</h2>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <th class="col-sm-6">Entity</th>
                <th class="col-sm-3">Opções</th>
            </thead>
            <tbody id='table-testes'>
            </tbody>
        </table>
    </div>
</div>

<script>
    const tableBody = $("#table-testes");
    const controllerUrl = udev.url.getUrlController();
    const seedEntity = udev.getVar('testes');

    buildTable();

    function buildTable() {
        tableBody.html(`${seedEntity.map((entity) => `
        <tr>
            <td>${entity}</td>
            <td>
                <a class='btn btn-success' href='${controllerUrl + '/test?name=' + entity}''>Pagina Teste ${entity}</a> 
            </td>
        </tr>
            `).join('')}`);
    }
</script>