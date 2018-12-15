<?php
	@ob_start();
	if(session_status()!=PHP_SESSION_ACTIVE) session_start()
?>