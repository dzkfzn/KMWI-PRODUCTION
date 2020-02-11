<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function printNotif($style = null)
{

	if ($style === 'warning')
		return '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="material-icons">close</i></button>';
	else if ($style === 'danger')
		return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="material-icons">close</i></button>';
	else if ($style === 'success')
		return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="material-icons">close</i></button>';
	else
		return '</div>';
}


