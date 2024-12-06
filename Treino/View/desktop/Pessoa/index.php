
<div class="root"></div>
<style>
    .shortDiv{
        max-width: 50px;
        max-height: 55px;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
<script src="/libs/BaseEmpds/scripts/consulta.js"></script>

<script>
    $(document).ready(()=>{
        const consultaJS = new ConsultaPadrao();
            consultaJS.addTitleTable("Consulta de Pessoas");
            consultaJS.addDataColumnsOnTable(
                [
                    {
                        title:"id",
                        data:"id"
                    },
                    {
                        title: 'Nome',
                        data: 'nome'
                    }
                ]
            )
                    
        
        consultaJS.addDataColumnsOnTable(
            [
                {
                    title:"CPF",
                    data: "cpf"
                },
                {
                    title: 'Idade',
                    data:"idade"
                }
            ]
        )
        consultaJS.addDefaultActions();

        consultaJS.setOption("columnDefs",[{
                className:'shortDiv',
                //coluna 0 e 3 tem o tamanho menor
                targets:[0,3]
            },]);
              consultaJS.iniciaConsulta();      
    })
</script>