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
                    <h2 class="title-1">Liste des réservations clients</h2>
                </div>
                <input class ="au-input" id="myInputC" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createR()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvelle réservation
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr class="text-center">
                            <th>Numéro réservation</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléhpone</th>
                            <th>Jour de la réservation</th>
                            <th>Heure de début</th>
                            <th></th>
                            <th>Heure de fin</th>
                            <th>Détails réservation</th>
                            <th class="text-center">Détails client</th>
                        </tr>
                        </thead>
                        <tbody id="TableResaC">
                        <?php foreach ($resaC as $ResaC){ ?>
                            <tr>
                                <td><?php echo $ResaC['ID_Reservation'];?></td>
                                <td><?php echo $ResaC['Nom'];?></td>
                                <td><?php echo $ResaC['Prenom'];?></td>
                                <td><?php echo $ResaC['Telephone'];?></td>
                                <td><?php echo  substr($ResaC['debut'], 0, 10);?></td>
                                <td><?php echo  substr($ResaC['debut'], 10, 6);?></td>
                                <td> à </td>
                                <td><?php echo  substr($ResaC['fin'], 10, 6);?></td>
                                <td>
                                    <a href="/inforeservation?id=<?php echo $ResaC['ID_Reservation'];?>" class="btn btn-info">Détails réservation</a>
                                </td>
                                <td>
                                    <a href="/infoclient?id=<?php echo $ResaC['ID_Personne'];?>" class="btn btn-info">Détails client</a>
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
        $("#myInputC").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#TableResaC tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function createR(){
        window.location.assign("/createreservation")
    }
</script>