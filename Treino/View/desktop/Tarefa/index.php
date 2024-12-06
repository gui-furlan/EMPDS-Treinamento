<div class="root"></div>
<style>
    .shortDiv {
        max-width: 50px;
        max-height: 55px;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<script src="/libs/BaseEmpds/scripts/consulta.js"></script>

<script>
    $(document).ready(() => {
        const consultaJS = new ConsultaPadrao();

        const membro = udev.getVar("membro");
        console.log(membro);

        if (membro != undefined) {
            const url = udev.url.buildUrl("@controller/getTarefasMembro", {
                query: {
                    membro: membro.id,
                },
            });
            consultaJS.setUrlAjax(url);
        } else {
            window.location.href = udev.url.getUrlModule();
        }

        consultaJS.addTitleTable("Consulta de Tarefa");
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
                    title: 'Descrição',
                    data: 'descricao'
                },
                {
                    title: 'Data de Registro',
                    data: 'dataRegistro'
                },
                {
                    title: 'Membro',
                    data: 'membro.pessoa.nome'
                }
            ]
        )

        consultaJS.addColumn({
            title: "Status",
            render: (data, type, row, meta) => {
                let isCompleta = row.completa ? "Completa" : "Incompleta";
                return "<article class='longtext' title='" + isCompleta + "'>" + isCompleta + "</article>"
            }
        });
        consultaJS.addActionVoltar(`${udev.url.getUrlModule()}/Membro/index/?equipe=${membro.equipe.id}`);

        consultaJS.addActionByValues(
            "btn-success", "fas fa-check", "Concluir",
                function (value) {
                    //concluir é alimentado pela opção do 
                    let concluir = confirm("Deseja mesmo concluir a tarefa?");
                    console.log(value);
                    if (concluir) {
                        BASE.sendRequest({
                            url: `${udev.url.getUrlController()}/completarTarefa?tarefaId=${value.id}`,
                            block: {
                                text: 'Completando...'
                            },
                            onSuccess: function (response) {
                                if (response.result !== 'error') {
                                    consultaJS.reload();
                                    BASE.printMensagem('success', "Tarefa completada");
                                    BASE.exibeMensagem();

                                } else {
                                    alert("Erro: " + response.message);
                                }
                            },
                            onError: function (response) {
                                alert("Erro ao alterar status da tarefa: " + (response.message || "error"));
                            }
                            
                            
                        });
                    }
                },
            function (value,row) {
                row.completa? value.attr("disabled",true):""
                console.log(value);   
            });
            
                

    consultaJS.addActionByValues("btn-warning", "fa fa-edit", "Alterar Tarefa", function (value, row) {
        window.location.href = `${udev.url.getUrlController()}/form/${value.id}/?membro=${membro.id}`
    });

    consultaJS.addActionExcluir();
    consultaJS.addColumnTableOptions();

    consultaJS.setOption("columnDefs", [{
        className: 'shortDiv',
        targets: [0]
    }]);

    consultaJS.iniciaConsulta();
    });
</script>