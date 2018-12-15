	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, MUST-REVALIDATE">

	<script src="js/jquery-3.3.1.min.js"></script>
	<!--script src="js/popper.js"></script-->
	<script src="js/popper-fix.min.js"></script>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="css/fontawesome.min.css">

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.js"></script>

	<!-- Your custom styles (optional) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

	<!--https://getmdl.io/started/index.html#download-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-blue.min.css">
	<!-- link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css" -->
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

	<!--
	<script src="js/plugins/moment.min.js"></script>
	<script src="js/plugins/bootstrap-datetimepicker.js"></script>
	https://eonasdan.github.io/bootstrap-datetimepicker/
	
	<script src="js/plugins/bootstrap-selectpicker.js"></script>
	<script src="js/plugins/bootstrap-tagsinput.js"></script>
	<script src="js/plugins/jasny-bootstrap.min.js"></script>
	<script src="js/plugins/jquery.flexisel.js"></script>
	<script src="js/plugins/jquery.sharrre.js"></script>
	<script src="js/plugins/nouislider.min.js"></script>
	-->
	

	<!-- Datatables -->
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />


	<script>
		$.put = function(url, data, callback, type){
			if ( $.isFunction(data) ){
				type = type || callback,
				callback = data,
				data = {}
			}
			return $.ajax({
				url: url,
				type: 'PUT',
				success: callback,
				data: data,
				contentType: type
			});
		}
	
		$.delete = function(url, data, callback, type){
			if ( $.isFunction(data) ){
				type = type || callback,
					callback = data,
					data = {}
			}
			return $.ajax({
				url: url,
				type: 'DELETE',
				success: callback,
				data: data,
				contentType: type
			});
		}
	</script>

	<style>
		/* Google Noto Fonts */
		@import url(https://fonts.googleapis.com/earlyaccess/notosanstc.css);
		* {
    		font-family: 'Noto Sans TC';
		}
		h2 {
			font-family: 'Noto Sans TC' !important;
		}
		
		/* Bootstrap Overwrite */
		.shadow {
    		box-shadow: 0 10px 15px rgba(0,0,0,.25) !important;
		}

		button:hover{cursor:pointer;}
		.dropdown:hover .dropdown-menu {display: block;}
		

		.t_input{
			height:23px !important;
			margin:0 !important;
			padding: 0px 0px !important;
			line-height: 23px !important;

			box-sizing: content-box;
		}
		.t_select{
			height:23px !important;
			margin:0 !important;
			padding: 3px 10px !important;

			box-sizing: content-box;
		}
		.t_button{
			height:23px !important;
			margin:0	 !important;
			padding: 0px 15px !important;
		}

		/* RWD Table */
		.rwd-table {
			background: #fff;
			overflow: hidden;
		}

		.rwd-table tr:nth-of-type(2n){
			background: #eee;
		}
		.rwd-table th, 
		.rwd-table td {
			margin: 0.5em 1em;
			padding: 0.5em !important;
		}
		.rwd-table {
			min-width: 100%;
		}

		.rwd-table th {
			color:#fff !important;
			background-color:#333 !important;
			display: none;
		}

		.rwd-table td {
			display: block;
		}

		.rwd-table td:before {
			content: attr(data-th) " ";
			font-weight: bold;
			width: 6.5em;
			display: inline-block;
		}

		.rwd-table th, .rwd-table td {
			text-align: left;
		}

		.rwd-table th, .rwd-table td:before {
			color: #D20B2A;
			font-weight: bold;
		}

		@media (min-width: 992px) {
			.rwd-table td:before {
				display: none;
			}
			.rwd-table th, .rwd-table td {
				display: table-cell;
				padding: 0.25em 0.5em;
			}
			.rwd-table th:first-child, 
			.rwd-table td:first-child {
				padding-left: 0;
			}
			.rwd-table th:last-child, 
			.rwd-table td:last-child {
				padding-right: 0;
			}
			.rwd-table th, 
			.rwd-table td {
				padding: 0.5em !important;
			}
		}
		/* RWD Table */

	/*
		tr:nth-child(odd){
			background-color:#ccf;
		}
		tr:nth-child(even){
			background-color:#fff;
		}
		tr:nth-child(odd):hover{
			background-color:#88f;
		}
		tr:nth-child(even):hover{
			background-color:#99f;
		}
	*/
		.t-bg-none{
			background-color:rgba(0,0,0,0);
		}
		.t-bg-reg{
			background-color:rgba(255,0,0,0.2);
		}
		.t-bg-green{
			background-color:rgba(0,255,0,0.2);
		}
	/* acc */
		.tNewBackground{
			background-color:rgba(255,0,0,0.1);
		}
		.tEditBackground{
			background-color:rgba(0,255,0,0.1);
		}
		.tQueryBackground{
			background-color:rgba(0,0,255,0.1);
		}
		.tQueryBackground2{
			background-color:rgba(0,255,255,0.1);
		}
		.tDebug{
			background-color:#444;
			color:#fff;
		}		
	</style>
</head>
<body>

<?php 
	$tForm1 = "form-inline";
	$tInput1 = 'form-control mr-sm-2 t_input';
	$tSelect1 = 'custom-select mr-sm-2 t_select';
	$tbutton_default = 'btn btn-success btn-sm t_button';
	$tbutton_light = 'btn btn-secondary btn-sm t_button';
	$tbutton_danger = 'btn btn-danger btn-sm t_button';
?>