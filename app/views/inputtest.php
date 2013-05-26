<!DOCTYPE html>
<?=Form::open(array(
				'url' => 'tickets/lineitem',
				'method' => 'post',
			))
?>

<?=Form::label('title', 'Line item title')?>
<?=Form::text('title')?>

<?=Form::label('ticket_type', 'Ticket type')?>
<?=Form::select('ticket_type', array('Duration'=>'Duration','Event'=>'Event'))?>


<?=Form::label('enabled', 'Enabled')?>
<?=Form::radio('enabled',1)?>
<?=Form::radio('enabled',0)?>

<?=Form::text('chickens')?>

<?=Form::submit()?>


<?=Form::close()?>