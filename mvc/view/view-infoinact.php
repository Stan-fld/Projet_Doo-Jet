<?php
//session_destroy();

//On récupère les infos de l'inacticité à partir de son id
$idemploye = $_GET["id"];
$id_inact = $model->getEmployemalade($idemploye);
if($id_inact == null){
    echo '<script type="text/javascript">alert("Aucune période d\'inactivité");history.back();</script>';
}
else {
    foreach ($id_inact as $inactivite) {
        $aff_inact = $model->getPeriodeinact($inactivite['ID_Inactivite']);
    }
?>
<!-- Title Page-->
<title>Périodes d'inactivité</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">

        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Périodes d'inactivité</h2>
                </div>
                <div style="margin-bottom: 1vh" class="te">
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Search..">
                    <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                        <i class="fa fa-caret-square-o-left"></i> Retour
                    </button>
                </div>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-30">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr>
                            <th style="width: 10%">Motif</th>
                            <th style="width: 0%">Date de début</th>
                            <th style="width: 20%">Date de fin</th>
                        </tr>
                        </thead>
                        <tbody id="TableInact">
                        <?php foreach ($aff_inact as $inact){ ?>
                            <tr>
                                <td style="width: 10%"><?php echo $inact['Motif'];?></td>
                                <td style="width: 0%"><?php echo $inact['Date_Debut_Inactivite'];?></td>
                                <td style="width: 20%"><?php echo $inact['Date_Fin_Inactivite'];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#TableInact tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    function backp(){
        history.back();
    }
</script>
<?php } ?>