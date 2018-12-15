<?php
(@$width=$_GET["w"]) or (@$width=0);
(@$height=$_GET["h"]) or (@$height=0);
(@$text=$_GET["t"]) or (@$text=$width."x".$height);
(@$bgcolor=$_GET["b"]) or (@$bgcolor="f00");
(@$color=$_GET["c"]) or (@$color="fff");

$fontsize=$width/50*6.5;
if ($fontsize>40){$fontsize=40;}

//$width 200 30
//		400 40
//		200 30
//		100 15
//		50 7.5

//header("Content-Disposition: attachment; filename=a.svg");
header('Content-Type: image/svg+xml');

echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
echo '<svg 
		version="1.1"
		id="Layer_1"
		xmlns="http://www.w3.org/2000/svg" 
		xmlns:xlink="http://www.w3.org/1999/xlink" 
		xml:space="preserve"

		width="'.$width.'" 
		height="'.$height.'" 
		viewBox="0 0 '.$width.' '.$height.'" 
		enable-background="new 0 0 '.$width.' '.$height.'"
		preserveAspectRatio="none">
		<defs>
			<style type="text/css">
				#holder_16792cb9639 text { fill:#'.$color.';font-weight:normal;font-family:Helvetica, monospace;font-size:'.$fontsize.'pt }
			</style>
		</defs>
		<g id="holder_16792cb9639">
			<rect width="'.$width.'" height="'.$height.'" fill="#'.$bgcolor.'"></rect>
			<g>
				<text x="'.($width/2-$fontsize*2.7).'" y="'.($height/2+$fontsize/2).'">
					'.$text.'
				</text>
			</g>
		</g>
	</svg>';
?>