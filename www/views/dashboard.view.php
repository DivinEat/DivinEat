
<div class="row">
    <div class="col-sm-4">
        <div class="col-inner padding-0">
            <select class="form-select" name="stats-date">
                <option value="today">Aujourd'hui</option>
                <option value="month">Mois en cours</option>
                <option value="3LastMonth">3 derniers mois</option>
                <option value="year">Cette année</option>
                <option value="allTime">Toujours</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-purple">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>19</h1>
                        <h2>En cours</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-white">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>11</h1>
                        <h2>Sur place</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-grey">
            <article>
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
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-grey">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>8</h1>
                        <h2>Sur place</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-purple">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>58</h1>
                        <h2>Terminées</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner  dashboard-item bg-white">
            <article>
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
    <div class="col-sm-4 ">
        <div class="col-inner dashboard-item bg-white">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>654, 33 €</h1>
                        <h2>Chiffre d'affaires</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container" class="graph-container">
                <canvas id="graph-CA" class="graph-canvas"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-grey">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>307</h1>
                        <h2>Visiteurs</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container" class="graph-container">
                <canvas id="graph-visiteurs" class="graph-canvas"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-purple">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>4</h1>
                        <h2>Nouveaux clients</h2>
                    </figcaption>
                </figure>
            </article>
            <div id="container" class="graph-container">
                <canvas id="graph-new-clients" class="graph-canvas"></canvas>
            </div>
        </div>
    </div>
</div>