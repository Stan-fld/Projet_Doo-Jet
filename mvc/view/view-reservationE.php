<?php
$resaC = $model->getReservationAll("Client");

$resaE = $model->getReservationEmp();

$resaEq = $model->getReservationEq();
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
                    <h2 class="title-1">Liste des réservations Employés</h2>
                </div>
                <input class ="au-input" id="myInputE" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createE()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvelle réservation
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr class="text-center">
                            <th>Numéro réservation</th>
                            <th>Numéro équipement</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléhpone</th>
                            <th>Jour de la réservation</th>
                            <th>Heure de début</th>
                            <th></th>
                            <th>Heure de fin</th>
                            <th>Détails réservation</th>
                            <th class="text-center">Détails employé</th>
                        </tr>
                        </thead>
                        <tbody id="TableResaE">
                        <?php foreach ($resaE as $ResaE){ ?>
                            <tr>
                                <td><?php echo $ResaE['ID_Reservation'];?></td>
                                <td><?php echo $ResaE['ID_Equipement'];?></td>
                                <td><?php echo $ResaE['Nom'];?></td>
                                <td><?php echo $ResaE['Prenom'];?></td>
                                <td><?php echo $ResaE['Telephone'];?></td>
                                <td><?php echo  substr($ResaE['debut'], 0, 10);?></td>
                                <td><?php echo  substr($ResaE['debut'], 10, 6);?></td>
                                <td> à </td>
                                <td><?php echo  substr($ResaE['fin'], 10, 6);?></td>
                                <td>
                                    <a href="/inforeservation?id=<?php echo $ResaE['ID_Reservation'];?>" class="btn btn-info">Détails réservation</a>
                                </td>
                                <td>
                                    <a href="/infoemploye?id=<?php echo $ResaE['ID_Personne'];?>" class="btn btn-info">Détails employé</a>
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
    $(document).ready(function() {
        $("#myInputE").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#TableResaE tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    function createE(){
        window.location.assign("/createreservation")
    }
</script>