<div class="root"></div>
<style>
    .shortDiv {
        max-width: 50px;
        max-height: 50px;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<script src="/libs/BaseEmpds/scripts/consulta.js"></script>

<script>
    $(document).ready(() => {
        const consultaJS = new ConsultaPadrao();
        consultaJS.addTitleTable("Consulta de Equipes");
        consultaJS.addDataColumnsOnTable(
            [
                {
                    title: "Id",
                    data: "id"
                },
                {
                    title: 'Nome',
                    data: 'nome'
                },
                {
                    title: 'Sigla',
                    data: 'sigla'
                },
                {
                    title: 'Descricao',
                    data: 'descricao'
                }
            ]
        )

        consultaJS.addActionByValues(
            "btn-success",
            "fas fa-user-plus",
            "Novo Membro",
            function (row) {
                window.location.href = `${udev.url.getUrlModule()}/Membro/form/?equipe=${row.id}`;
            });
        consultaJS.addActionByValues(
            "btn-primary",
            "fas fa-search",
            "Ver Membros",
            function (row) {
                window.location.href = `${udev.url.getUrlModule()}/Membro/index/?equipe=${row.id}`;
            });

        consultaJS.addDefaultActions();
        consultaJS.setOption("columnDefs", [{
            className: 'shortDiv',
            targets: [0, 2]
        },]);
        consultaJS.iniciaConsulta();
    })
</script>