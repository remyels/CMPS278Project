

<div class="content">
    <div class="container">
        <div class="jumbotron" style="background: white">

<ul class="nav nav-tabs" id="myTab" role="tablist" style="background: lightgrey">
    <li class="nav-item">
        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" id="portfolios-tab" data-toggle="tab" href="#portfolios" role="tab" aria-controls="portfolios" aria-selected="false">My Portfolios</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="investments-tab" data-toggle="tab" href="#investments" role="tab" aria-controls="investments" aria-selected="false">My Investments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="automate-tab" data-toggle="tab" href="#automate" role="tab" aria-controls="automate" aria-selected="false">Automate</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
        summary here
    </div>
    <div class="tab-pane fade" id="portfolios" role="tabpanel" aria-labelledby="portfolios-tab">

    </div>
    <div class="tab-pane fade" id="investments" role="tabpanel" aria-labelledby="investments-tab">
        <?php include 'myInvestments.php' ?>
    </div>
    <div class="tab-pane fade" id="automate" role="tabpanel" aria-labelledby="automate-tab">
        <?php include 'automate.php' ?>
    </div>
</div>

        </div>



    </div>
</div>

