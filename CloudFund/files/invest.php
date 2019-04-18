<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
</head>
<body style="">

<?php include 'loggedinnavbar.php'; ?>

<div class="content-wrapper">
<div class="modal fade" tabindex="-1" id="investModal" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">Invest in this listing</h4>
				</div>
				<div class="modal-body">
					<form method="GET" action="#">
						<div class="form-group">
							<label for="inputFirstName">How many credits would you like to invest?</label>
							<input class="form-control" placeholder="Investment value in Credits"
									type="text" id="inputInvestment" name="inputInvestment" />
						</div>
					</form>
					<span id="investmentResult" style="color: white; user-select: none" >WHITESPACE</span>
				</div>
				<div class="modal-footer">
					<button type="submit" id="submitInvestmentBtn" class="btn btn-success">Invest <i class="fa fa-money" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-danger"
							data-dismiss="modal">Close</button>
				</div>
			</div>
		
      </div>
	  
      </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="jumbotron" style="margin-top: 5%; background: #e7e7e7">

                    <?php
                    /**
                     * Created by PhpStorm.
                     * User: RemyEls
                     * Date: 8/16/2018
                     * Time: 8:25 PM
                     */
                    //The following is to be inserted in place of the dummy data
                    ?>

                    <?php

                    include '../connect/connectPDO.php';

                    $query = "SELECT * FROM listing JOIN purpose ON listing.purposeid = purpose.purposeid;";

                    $rows = $db->query($query);

                    //Need to check if listings are found

                    if ($rows->rowCount()!=0) { ?>
                        <h1>Listings</h1>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="centerData">Credit</th>
                                <th scope="col" class="centerData">Months</th>
                                <th scope="col" class="centerData">Amount</th>
                                <th scope="col" class="centerData">Purpose</th>
                                <th scope="col" class="centerData">% Funded</th>
                                <th scope="col" class="centerData">Amount / Time Left</th>
                                <th scope="col" class="centerData">Option</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($rows as $row) {
                                //We need to check corresponding in
                                $listingID = $db->quote($row['ListingID']);
                                $query = "SELECT * FROM investment WHERE ListingID = $listingID";

                                $result = 0;

                                $investRows = $db->query($query);

                                if ($investRows->rowCount()>0) {
                                    foreach ($investRows as $investRow) {
                                        $result = $result + $investRow['AmountInvested'];
                                    }
                                }
                                //else result stays 0 LOL

                                //We need the percentage:
                                $percentage = floor(($result/$row['Amount'])*100);
                                //We shall put the above in the row

                                //Now, let's figure out how many days are left
                                $listingDate = date("Y-m-d", strtotime($row['ListingDate']));

                                //We add the time limit in days to that, PHP is magical!
                                $deadline = date("Y-m-d", strtotime($listingDate." ".$row['TimeLimit']." days"));

                                //Now we get the current time
                                $currenttime = date("Y-m-d");

                                //Get the difference in seconds
                                $difference = strtotime($deadline)-strtotime($currenttime);

                                //convert to days
                                $difference /= 86400;

                                $moneylefttocomplete = $row['Amount'] - $result;

                                ?>
                                <!-- HTML CODE GOES HERE -->
                                <tr>
                                    <!-- for now, all classes are C -->
                                    <td class="centerData">C</td>
                                    <td class="centerData"><?= $row['BorrowDuration'] ?></td>
                                    <td class="centerData"><?= number_format($row['Amount']) ?> Credits</td>
                                    <td class="centerData"><?= $row['PurposeType'] ?></td>
                                    <td title="<?=$row['Amount']-$moneylefttocomplete?> Credits funded so far" class="centerData">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%; background: forestgreen" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">

                                            </div>
                                        </div>
                                    </td>
                                    <td class="centerData"><?= number_format($moneylefttocomplete) ?> Credits<br> <?php if ($difference < 0) { ?>
                                            <span style="color: red">Expired</span>
                                        <?php } else if ($difference == 0) { ?>
                                            Today!
                                        <?php } else if ($difference==1) { ?>
                                            1 days
                                        <?php } else { ?>
                                            <?= $difference ?> days
                                        <?php } ?>
                                    </td>
                                    <td class="centerData">
                                        <button type="button" id="<?= $row['ListingID'] ?>"class="investBtn btn btn-info btn-xs" data-toggle="modal" data-target="#investModal" style="background-color: rgb(237, 57, 36); border-color: rgb(237, 57, 36)">Invest!</button>
                                    </td>
                                </tr>

                            <?php } ?>
                            </tbody>
                        </table>
                    <?php }
                    else { ?>
                    <!-- this table will contain the listings, change as you deem fit -->
                    <h3 style="color: red; text-align: center">There are no available listings at the moment, please check back later!</h3>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="static/invest.js"></script>
</body>
</html>



