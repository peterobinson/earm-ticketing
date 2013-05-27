<!DOCTYPE html>
<?=Form::open(array(
				'url' => 'tickets/tickettype',
				'method' => 'post',
			))
?>

<?=Form::label('name', 'Name')?>
<?=Form::text('name')?>

<?=Form::label('price', 'price')?>
<?=Form::text('price')?>


<?=Form::label('duration', 'Duration')?>
<?=Form::text('duration')?>

<?=Form::label('start_day', 'Day')?>
<?=Form::text('start_day')?>

<?=Form::label('start_month', 'Month')?>
<?=Form::text('start_month')?>

<?=Form::label('start_year', 'Year')?>
<?=Form::text('start_year')?>

<?=Form::submit()?>


<?=Form::close()?>