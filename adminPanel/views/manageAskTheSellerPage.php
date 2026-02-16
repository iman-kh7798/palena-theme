<?php
global $wpdb;
if ( isset( $_REQUEST['askToRemove'] ) && ! empty( $_REQUEST['askToRemove'] ) ) {
	$resultToDelete = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ask_the_seller WHERE id = {$_REQUEST['askToRemove']}" );
	if ( $resultToDelete ) {
		$resultToDelete = $resultToDelete[0];

		$wpdb->delete( $wpdb->prefix . 'ask_the_seller', array( 'id' => $_REQUEST['askToRemove'] ) );
	}

}
if ( isset( $_REQUEST['bim'] ) && ! empty( $_REQUEST['bim'] ) ) {
	$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
	$date=$date->format('Y-m-d H:i:s');
	$wpdb->update( $wpdb->prefix . 'ask_the_seller', array( 'seen'=> 'yes','OperatorDescription'=>sanitize_textarea_field($_REQUEST['OperatorDescription']),'updated_at' => $date
	), array( 'id' => $_REQUEST['bim'] ) );
}
if (isset($_REQUEST['reUpdate'])  && !empty($_REQUEST['reUpdate'])){
	$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
	$date=$date->format('Y-m-d H:i:s');
	$wpdb->update($wpdb->prefix.'ask_the_seller', array('seen'=>'no','updated_at'=>$date), array('id'=>$_REQUEST['reUpdate']));

}
if ( isset( $_REQUEST['status'] ) && ! empty( $_REQUEST['status'] ) && $_REQUEST['status'] == 'seen' ) {
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ask_the_seller WHERE seen = 'yes' ORDER BY `id` DESC " );
	$seen    = 'seen';
} else {
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ask_the_seller WHERE seen = 'no' ORDER BY `id` DESC " );
	$seen    = 'not';
}
?>
<div class="wrap hh-font-family">
    <div style="display: inline-flex; align-items: center; justify-content: space-between; width: 100%; align-content: center">
        <div class="row-title">Manage Ask The Seller Requests <?php if ( $seen == 'not' ): ?>
                ( Unverified  )
			<?php else: ?>
                ( Verified   )
			<?php endif; ?></div>

		<?php if ( $seen == 'not' ): ?>
            <form action="<?= menu_page_url( 'manageAskTheSellerPage' ) ?>" method="get">
                <input type="hidden" name="page" value="ask_the_seller">
                <input type="hidden" name="status" value="seen">
                <button type="submit" class="button-primary">Go to Verified Ask The Sellers</button>
            </form>
		<?php else: ?>
            <form action="<?= menu_page_url( 'manageAskTheSellerPage' ) ?>" method="get">
                <input type="hidden" name="page" value="ask_the_seller">
                <input type="hidden" name="status" value="not">
                <button type="submit" class="button-primary">Go to Unverified Ask The Sellers</button>
            </form>
		<?php endif; ?>
    </div>
	<?php
	if ( count( $results ) ):?>
        <table class="wp-list-table widefat plugins" style="margin-top: 20px;">
            <thead>
            <tr class="row-title">
                <th scope="col" colspan="1" class="manage-column column-primary"><span>#</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Name</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Family</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Phone</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Status</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary" ><span>Email</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Message</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Designer</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Company</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Resale</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Address</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Seller</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Size</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Product</span></th>
                <th scope="col" colspan="2" class="manage-column column-primary"><span>Date</span></th>
            </tr>
            </thead>

            <tbody>
			<?php foreach ( $results as $key => $result ): ?>
                <tr <?= $key % 2 ? '' : 'class="active"' ?> style="cursor: pointer" onclick="showRow('<?= $result->id ?>')">
                    <td class="column-primary" colspan="1"><span><?= $result->id ?></span></td>
                    <td class="column-primary" colspan="2"><span><?= $result->name ?></span></td>
                    <td class="column-primary" colspan="2"><span><?= $result->family ?></span></td>
                    <td class="column-primary" colspan="2"><span><?= $result->phone ?></span></td>
                    <td class="column-primary"
                        colspan="2"><?= $result->seen == 'no' ? '<span style="color: #ff0000">Unverified</span>' : '<span style="color: #0000ff">Verified</span>' ?></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->email ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->message ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->designer ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->Company ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->Resale ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->address ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->seller ?></span></td>
                    <td class="column-primary" colspan="2" ><span><?= $result->size ?></span></td>
                    <td class="column-primary" colspan="2" ><span><a href="<?= $result->postLink ?>"><?= $result->postTitle ?></a></span></td>

                    <td class="column-primary" colspan="2">
                        <div class=""><span>
	                            <?=$result->created_at?>
                            </span></div>
                    </td>

                </tr>
        <tr id="row<?= $result->id ?>" class="row-shows <?= $key % 2 ? '' : ' active' ?>"  style="display: none">
            <td class="" colspan="28" style="width: 100%" >


			        <?php if ( $seen == 'not' ): ?>
                        <form action="<?= menu_page_url( 'manageAskTheSellerPage' ) ?>" method="get" style="display: flex">
                            <input type="hidden" name="page" value="ask_the_seller">
                            <input type="hidden" name="status" value="not">
                            <input type="hidden" name="bim" value="<?= $result->id ?>">
                            <div class="widefat">
                                <label for="OperatorDescription">Operator Description</label>
                                <textarea name="OperatorDescription" required id="OperatorDescription" style="width: 100%"
                                          rows="2"><?=nl2br($result->OperatorDescription)?></textarea>
                            </div>
                            <div class="hh-width25 " style="padding-right: 15px; padding-top: 27px; margin-left: 30px;" >
                                <button type="submit" class="button-primary ">Verified</button>
                            </div>


                        </form>
			        <?php else: ?>
                    <div class="hh-width100">
                        <span>Operator Description:</span>
                        <br>
                        <p style="background: #135e25; color: white; padding: 15px 10px"><?=nl2br($result->OperatorDescription)?></p>
                    </div>
                        <span>Verified at :
	                                <?=$result->updated_at?>&nbsp;&nbsp;&nbsp;&nbsp;
                                   Created at <?=$result->updated_at?>
                                </span>
                        <hr>
                        <div class="hh-m1 hh-color-blue hh-width100" style="display: flex">
                        <form action="<?= menu_page_url( 'manageAskTheSellerPage' ) ?>" method="get" class="hh-width50">
                            <input type="hidden" name="page" value="ask_the_seller">
                            <input type="hidden" name="status" value="seen">
                            <input type="hidden" name="askToRemove" value="<?= $result->id ?>">
                            <button type="submit" style="background: red;color:white;" class="button" onclick="return confirm('Are you sure you want to delete this? ')">Delete</button>
                        </form>

                            <form action="<?= menu_page_url('manageAskTheSellerPage')?>" method="get" class="hh-width50">
                                <input type="hidden" name="page" value="ask_the_seller">
                                <input type="hidden" name="reUpdate" value="<?=$result->id?>">
                                <input type="hidden" name="status" value="<?=$seen?>">
                                <button type="submit" style="background: blue;color:white;" class="button">Change Status to UnVerified</button>
                            </form>
                        </div>
			        <?php endif; ?>


            </td>
        </tr>
			<?php endforeach;
            else:?>
            <p style="width: 98%; color: aliceblue; background: green;padding: 10px;border-radius: 5px;">There is nothing to display ! </p>
            </tbody>


        </table>
	<?php endif; ?>

</div>

