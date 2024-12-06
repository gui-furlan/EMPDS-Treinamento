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
        const idEquipe = udev.getVar("idEquipe");
        const url = udev.url.buildUrl("@controller/getMembroByEquipeId", {
            query: {
                equipe: idEquipe,
            },
        });

        consultaJS.addTitleTable("Consulta de Membros");
        consultaJS.addDataColumnsOnTable(
            [
                {
                    title: "Id",
                    data: "id"
                },
                {
                    title: 'Equipe',
                    data: 'equipe.nome'
                },
                {
                    title: 'Pessoa',
                    data: 'pessoa.nome'
                },

            ]
        )

        consultaJS.setUrlAjax(url);
        consultaJS.addActionNovo(`${udev.url.getUrlController()}/form/?equipe=${idEquipe}`);

        consultaJS.addActionVoltar(`${udev.url.getUrlModule()}/Equipe/index`);

        consultaJS.addActionByValues("btn btn-success", "fas fa-business-time", "Nova Tarefa",
        function (row) {
            window.location.href = (`${udev.url.getUrlModule()}/Tarefa/form/?membro=${row.id}`)    
        })

        consultaJS.addActionByValues("btn btn-warning", "fas fa-calendar-alt", "Consultar Tarefa",
        function (row) {
            window.location.href = (`${udev.url.getUrlModule()}/Tarefa/index/?membro=${row.id}`)    
        })
        //desfazer relação de membro com equipe
        consultaJS.addActionExcluir();
        //adicionar a coluna onde ficam as opções extras
        consultaJS.addColumnTableOptions();


        consultaJS.setOption("columnDefs", [{
            className: 'shortDiv',
            targets: [0]
        },]);
        consultaJS.iniciaConsulta();
    })
</script>