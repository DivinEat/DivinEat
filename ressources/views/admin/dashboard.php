
<div class="row">
    <div class="col-sm-2">
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
    <div class="col-sm-10">
        <div class="col-inner padding-0">
            <h1 class="margin-0">Les commandes</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="col-inner dashboard-item bg-purple">
            <article>
                <figure>
                    <figcaption class="stats">
                        <h1>?</h1>
                        <h2>?</h2>
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
                        <h1><?= $totalOrdersOnSite ?></h1>
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
                        <h1><?= $totalOrdersTakeOut ?></h1>
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
                        <h1><?= $totalOrdersInProgress ?></h1>
                        <h2>En cours</h2>
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
                        <h1><?= $totalOrdersCompleted ?></h1>
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
                        <h1><?= $total ?></h1>
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
                        <h1><?= $caTotal ?> €</h1>
                        <h2>Chiffre d'affaires</h2>
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
                        <h1><?= $visitors ?></h1>
                        <h2>Visiteurs</h2>
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
                        <h1><?= $newUsers ?></h1>
                        <h2>Nouveaux clients</h2>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</div>