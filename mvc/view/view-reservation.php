<?php
$resa = $model->getReservationAll();
?>

<!-- Title Page-->
<title>Liste des réservations</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des réservations</h2>
                </div>
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createE()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvel réservation
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr class="text-center">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléhpone</th>
                            <th>Jour de la réservation</th>
                            <th>Heure de début</th>
                            <th></th>
                            <th>Heure de fin</th>
                            <th>Détails réservation</th>
                            <th>Détails client</th>
                        </tr>
                        </thead>
                        <tbody id="TableClient">
                        <?php foreach ($resa as $Resa){ ?>
                            <tr>
                                <td><?php echo $Resa['Nom'];?></td>
                                <td><?php echo $Resa['Prenom'];?></td>
                                <td><?php echo $Resa['Telephone'];?></td>
                                <td><?php echo  substr($Resa['debut'], 0, 10);?></td>
                                <td><?php echo  substr($Resa['debut'], 10, 6);?></td>
                                <td> à </td>
                                <td><?php echo  substr($Resa['fin'], 10, 6);?></td>
                                <td>
                                    <a href="/inforeservation?id=<?php echo $Resa['ID_Reservation'];?>" class="btn btn-info">Détails réservation</a>
                                </td>
                                <td>
                                    <a href="/infoclient?id=<?php echo $Resa['ID_Personne'];?>" class="btn btn-info">Détails client</a>
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

    function createE(){
        window.location.assign("/creatreservation")
    }
</script>