<?php
$equipements = $model->getEquipementAll();
?>

<!-- Title Page-->
<title>Liste des équipements</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des équipements</h2>
                </div>
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                        <tr class="text-center">
                            <th>Nom</th>
                            <th>Commentaire</th>
                            <th>Puissance</th>
                            <th>Service</th>
                            <th>Fiche employé</th>
                        </tr>
                        </thead>
                        <tbody id="TableClient" class="text-center">
                        <?php foreach ($equipements as $equipement){ ?>
                            <tr>
                                <td><?php echo $equipement['Nom_Equipement'];?></td>
                                <td><?php echo $equipement['Commentaire'];?></td>
                                <td><?php echo $equipement['Puissance'];?></td>
                                <?php if($equipement['Service'] == 1){ ?>
                                    <td>En service</td>
                                <?php }else{ ?>
                                    <td>Hors service</td>
                                <?php } ?>
                                <td>
                                    <a href="/infoequipement?id=<?php echo $equipement['ID_Equipement'];?>" class="btn btn-info">Détails</a>
                                </td>
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
            $("#TableClient tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>