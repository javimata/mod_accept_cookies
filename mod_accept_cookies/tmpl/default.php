<?php
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();

// Obtener valores
$position           = $params->get("position",1);
$contentText        = $params->get("content");
$button_accept      = $params->get("button_accept");
$button_close_class = $params->get("button_close_class","glyphicon glyphicon-remove-circle");
$add_fontawesome    = $params->get("add_fontawesome",0);
$source_fontawesome = $params->get("source_fontawesome",1);
$fontawesome_url    = $params->get("fontawesome_url");
$className          = $params->get("className");
$idName				= $params->get("idName");
$cookie_lifetime    = $params->get("cookie_lifetime",1);
$cookie_domain      = $params->get("cookie_domain");

// Agrega el CSS de fontawesome tomando la url dada
if ( $add_fontawesome == 1  ){

	if ( $source_fontawesome == 1 && $fontawesome_url != "" ) {

		$url_fontawesome = $fontawesome_url;

	}else {

		$url_fontawesome = JURI::base(true) . "/modules/".$module->module."/assets/font-awesome.min.css";

	}

	$document->addStylesheet($url_fontawesome);

}

$document->addStylesheet(JURI::base(true) . "/modules/".$module->module."/assets/css/style.css");
$document->addScript(JURI::base(true) . "/modules/".$module->module."/assets/js/jquery-cookie.min.js");


if ( $position == 1 ) {
	$style = ".acepta-cookies { bottom: inherit; top: 0; }";
	$document->addStyleDeclaration($style);
}


$cookie_name = md5("acepta_cookies");
if( !isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != 1 ):
?>

	<div class="acepta-cookies">
		<?php echo $contentText; ?>
		<a href="#" class="cerrar-acepta"><span class="btn-close <?php echo $button_close_class; ?>" aria-hidden="true"></span></a>
	</div>

	<script>
		(function($) {
			$.cookie('<?php echo $cookie_name; ?>', '1', { expires: <?php echo $cookie_lifetime; ?>, path: '<?php echo $cookie_domain; ?>' });
			$("a.cerrar-acepta").click(function(e){
				e.preventDefault();
				$("div.acepta-cookies").fadeOut();
			});
		}).apply(this, [jQuery]);
	</script>

<?php endif; ?>