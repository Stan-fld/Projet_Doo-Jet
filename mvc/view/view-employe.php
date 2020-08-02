<?php
$employes = $model->getEmployeAll();
?>

<!-- Title Page-->
<title>Liste des employés</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des employés</h2>
                </div>
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createE()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvel employé
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                        <tr class="text-center">
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Date de naissance</th>
                            <th>Téléhpone</th>
                            <th>Numéro de permis</th>
                            <th>Numéro BEES</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code postal</th>
                            <th>Pays</th>
                            <th>Fiche employé</th>
                        </tr>
                        </thead>
                        <tbody id="TableClient">
                        <?php foreach ($employes as $employe){ ?>
                            <tr>
                                <td><?php echo $employe['Nom'];?></td>
                                <td><?php echo $employe['Prenom'];?></td>
                                <td><?php echo $employe['anniv'];?></td>
                                <td><?php echo $employe['Telephone'];?></td>
                                <td><?php echo $employe['N_Permis'];?></td>
                                <td><?php echo $employe['N_BEES'];?></td>
                                <td><?php echo $employe['Numero_Rue']." ".$employe['Type_Voie']." ".$employe['Rue'];?></td>
                                <td><?php echo $employe['Nom_Ville'];?></td>
                                <td><?php echo $employe['Code_Postal'];?></td>
                                <td><?php echo $employe['Nom_Pays'];?></td>
                                <td>
                                    <a href="/infoemploye?id=<?php echo $employe['ID_Personne'];?>" class="btn btn-info">Détails</a>
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
        window.location.assign("/createemploye")
    }
</script>