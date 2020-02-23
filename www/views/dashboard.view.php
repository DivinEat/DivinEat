<select class="form-select" name="stats-date">
    <option value="today">Aujourd'hui</option>
    <option value="month">Mois en cours</option>
    <option value="3LastMonth">3 derniers mois</option>
    <option value="year">Cette année</option>
    <option value="allTime">Toujours</option>
</select>

<div class="row">
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-purple">
                <figure>
                    <figcaption class="stats">
                        <h1>19</h1>
                        <h2>En cours</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-white">
                <figure>
                    <figcaption class="stats">
                        <h1>11</h1>
                        <h2>Sur place</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-grey">
                <figure>
                    <figcaption class="stats">
                        <h1>58</h1>
                        <h2>A emporter</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-grey">
                <figure>
                    <figcaption class="stats">
                        <h1>8</h1>
                        <h2>Sur place</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-purple">
                <figure>
                    <figcaption class="stats">
                        <h1>58</h1>
                        <h2>Terminées</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-white">
                <figure>
                    <figcaption class="stats">
                        <h1>77</h1>
                        <h2>Total</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-white">
                <figure>
                    <figcaption class="stats">
                        <h1>654, 33 €</h1>
                        <h2>Chiffre d'affaires</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container">
                <canvas id="graph-CA"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner">
            <article class="bg-grey">
                <figure>
                    <figcaption class="stats">
                        <h1>307</h1>
                        <h2>Visiteurs</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container">
                <canvas id="graph-visiteurs"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-4 dashboard-item">
        <div class="col-inner ">
            <article class="bg-purple">
                <figure>
                    <figcaption class="stats">
                        <h1>4</h1>
                        <h2>Nouveaux clients</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container" class="graph-container">
                <canvas id="graph-new-clients"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx_graph_CA = document.getElementById("graph-CA");
    var data_graph_CA = {
        labels: ["21/02", "22/02", "23/02", "24/02", "25/02", "26/02"],
        datasets: [{
            label: 'Chiffre d\'affaires',
            data: [300.30, 344.12, 443.28, 616.32, 803.33, 849.90],
            backgroundColor: [
                'rgba(240,240,240,1)'
            ],
            borderColor: [
                'rgba(170,170,170,1)'
            ],
            borderWidth: 1
        }]
    };

    var options_graph_CA = {
        scales: {
            yAxes: [{
                ticks: { // utile pour que les valeurs min et max ne soient pas celles du dataset
                    beginAtZero:true, 
                    suggestedMax: 1000
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 20,
                bottom: 20
            }
        },
        title: {
            display: false,
            text: 'Chiffre d\'affaires',
            fontSize: 20
        },
        legend: {
            display: false,
        }
    }

    var ctx_graph_visiteurs = document.getElementById("graph-visiteurs");
    var data_graph_visiteurs = {
        labels: ["21/02", "22/02", "23/02", "24/02", "25/02", "26/02"],
        datasets: [{
            label: 'Nombre de visiteurs',
            data: [255, 289, 378, 390, 466, 972],
            backgroundColor: [
                'rgba(231,224,244,1)'
            ],
            borderColor: [
                'rgba(170,170,170,1)'
            ],
            borderWidth: 1
        }]
    };

    var options_graph_visiteurs = {
        scales: {
            yAxes: [{
                ticks: { // utile pour que les valeurs min et max ne soient pas celles du dataset
                    beginAtZero:true, 
                    suggestedMax: 1000
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 20,
                bottom: 20
            }
        },
        title: {
            display: false,
            text: 'Nombre de visiteurs',
            fontSize: 20
        },
        legend: {
            display: false,
        }
    }

    var ctx_graph_new_clients = document.getElementById("graph-new-clients");
    var data_graph_new_clients = {
        labels: ["21/02", "22/02", "23/02", "24/02", "25/02", "26/02"],
        datasets: [{
            label: 'Nouveaux clients',
            data: [1, 1, 3, 1, 2, 4],
            backgroundColor: [
                'rgba(255,255,255,1)'
            ],
            borderColor: [
                'rgba(170,170,170,1)'
            ],
            borderWidth: 1
        }]
    };

    var options_graph_new_clients = {
        scales: {
            yAxes: [{
                ticks: { // utile pour que les valeurs min et max ne soient pas celles du dataset
                    beginAtZero:true, 
                    suggestedMax: 5
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 20,
                bottom: 20
            }
        },
        title: {
            display: false,
            text: 'Nouveaux clients',
            fontSize: 20
        },
        legend: {
            display: false,
        }
    }

    var graphCA = new Chart(ctx_graph_CA, {
        type: 'line',
        data: data_graph_CA,
        options: options_graph_CA
    });
    var graphVisiteurs = new Chart(ctx_graph_visiteurs, {
        type: 'line',
        data: data_graph_visiteurs,
        options: options_graph_visiteurs
    });
    var graphNewClients = new Chart(ctx_graph_new_clients, {
        type: 'line',
        data: data_graph_new_clients,
        options: options_graph_new_clients
    });
</script>
