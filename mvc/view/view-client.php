<?php
$clients = $model->getClientAll();
?>

<!-- Title Page-->
<title>Liste des clients</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des clients</h2>
                </div>
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Search..">
                <button style="margin-left: 2vh" onclick="createC()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouveau client
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                        <tr >
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Date de naissance</th>
                            <th>Téléhpone</th>
                            <th>Numéro de permis</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code postal</th>
                            <th>Pays</th>
                            <th style="font-size: 0.85rem">Fiche client</th>
                        </tr>
                        </thead>
                        <tbody id="TableClient">
                        <?php foreach ($clients as $clts){ ?>
                            <tr>
                                <td><?php echo $clts['Nom'];?></td>
                                <td><?php echo $clts['Prenom'];?></td>
                                <td><?php echo $clts['anniv'];?></td>
                                <td><?php echo $clts['Telephone'];?></td>
                                <td><?php echo $clts['N_Permis'];?></td>
                                <td><?php echo $clts['Numero_Rue']." ".$clts['Type_Voie']." ".$clts['Rue'];?></td>
                                <td><?php echo $clts['Nom_Ville'];?></td>
                                <td><?php echo $clts['Code_Postal'];?></td>
                                <td><?php echo $clts['Nom_Pays'];?></td>
                                <td>
                                    <a href="/infoclient?id=<?php echo $clts['ID_Personne'];?>" class="btn btn-info">Détails</a>
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

    function createC(){
        window.location.assign("/createclient")
    }
</script>