<div class="container">
    <h3>Geração de arquivo de BACKUP do sistema</h3>
    <button type="button" id="gerar" class="btn btn-success" data-dismiss="modal">Gerar</button>
</div>
<script>
    function initDatabaseDumpEvent(){
        $("#gerar").on('click', startDatabaseDumpEvent);
    }

    function startDatabaseDumpEvent(e){
        const controllerUrl = udev.url.getUrlController();
        fetch(`${controllerUrl}/dump`)
            .then(resp => resp.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = 'database.sql';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                alert('Arquivo disponibilizado com sucesso!'); // or you know, something with better UX...
            })
            .catch((e) => alert('Error: '.e));
    }

    $(document).ready(function() {
        initDatabaseDumpEvent();
    });
</script>