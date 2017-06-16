<?php
defined('_JEXEC') or die('Restricted access');
DEFINE('MOD_SS_ASSETS',JURI::base(true) . "/modules/".$module->module."/assets/");
jimport('joomla.filesystem.file');

//Get the configuration options
$source                = $params->get("source",1);
$slides_show           = $params->get("slides_show",1);
$slides_limit          = $params->get("slides_limit",0);
$config_accessibility  = $params->get("config_accessibility",'false');
$config_adaptiveheight = $params->get("config_adaptiveheight",'false');
$config_autoplay       = $params->get("config_autoplay",'true');
$config_arrows         = $params->get("config_arrows",'true');
$config_centermode     = $params->get("config_centermode",'false');
$config_dots           = $params->get("config_dots",'true');
$config_draggable      = $params->get("config_draggable",'true');
$config_fade           = $params->get("config_fade",'false');
$config_variablewidth  = $params->get("config_variablewidth",'false');
$target_link           = $params->get("target_link",1);
$add_css			   = $params->get("add_css","true");

// Get the plugin information
$source_plugin = $params->get("source_plugin",1);
( $source_plugin == 2 ) ? $source_plugin_js = $params->get("source_plugin_js") : $source_plugin_js = MOD_SS_ASSETS."js/slick.js";
( $source_plugin == 2 ) ? $source_plugin_css = $params->get("source_plugin_css") : $source_plugin_css = MOD_SS_ASSETS."css/slick.css";
( $source_plugin == 2 ) ? $source_plugin_theme = $params->get("source_plugin_theme") : $source_plugin_theme = MOD_SS_ASSETS."css/slick-theme.css";

$document = JFactory::getDocument();
$document->addStylesheet($source_plugin_css);
$document->addStylesheet($source_plugin_theme);
$document->addScript($source_plugin_js);

if ( $add_css == "true" ){
	$document->addStylesheet( MOD_SS_ASSETS."css/custom_style.css" );	
}


// Get the advanced information
$className          = $params->get("className");
$idName             = $params->get("idName",$module->id);
$show_title_item    = $params->get("show_title_item",false);
$show_readmore_item = $params->get("show_readmore_item",false);
?>
<div class="container-slider-slick id-<?php echo $module->id;?> <?php echo $className;?>" id="<?php echo $idName;?>">
		
	<?php if ( count( $items ) ): ?>		

		<?php foreach ($items as $item): 

			switch ($source) {
				case 1:
		            $source_images = $params->get("source_content_image",1);
		            $source_content_link = $params->get("source_content_link",1);
		            $imagenes      = json_decode($item->images);
		            ( $source_images == 1 ) ? $imagen = $imagenes->image_intro : $imagen = $imagenes->image_fulltext;

		            if ( $source_content_link == 2 ):
						JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');
			            $item->slug    = $item->id . ':' . $item->alias;
			            $urlItem = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));

			        elseif ( $source_content_link == 3 || $source_content_link == 4 || $source_content_link == 5 ):

			        	$urlsItem = json_decode($item->urls);

			        	if ( $source_content_link == 3 ) {
			        		$urlItem = $urlsItem->urlatext;
			        	}elseif ( $source_content_link == 4 ) {
			        		$urlItem = $urlsItem->urlbtext;
			        	}elseif ( $source_content_link == 5 ) {
			        		$urlItem = $urlsItem->urlctext;
			        	};

			        elseif ( $source_content_link == 6 ):

			        	$linkType = "popup";

		            endif;

					break;
				
				case 2:
					$parametros          = json_decode($item->params);
					$imagen              = $parametros->imageurl;
					$source_banners_link = $params->get("source_banners_link",1);

		            if ( $source_banners_link == 2 ):

						$urlItem = $item->clickurl;

			        elseif ( $source_banners_link == 3 ):

			        	$linkType = "popup";

		            endif;

					break;

				case 3:
					# code...
					break;
			}

			if ( $linkType == "popup" ) {

				$document->addStylesheet(MOD_SS_ASSETS . "css/magnific-popup.css");
				$document->addScript(MOD_SS_ASSETS . "js/jquery.magnific-popup.min.js");

			}

		?>
		<?php if ($imagen!="" && JFile::exists( $imagen) ): ?>
			<div class="item">
		
				<div class="item-slide-container">
					<?php if ( $urlItem ): ?>
					<a href="<?php echo $urlItem; ?>" <?php if ($target_link == 2) { echo 'target="_blank"'; } ?>>
					<?php elseif ($linkType == "popup"): ?>
					<a href="<?php echo JURI::BASE(). $imagen; ?>" class="image-link popup">
					<?php endif; ?>

					<div class="item-slide-image">					
					<img src="<?php echo JURI::BASE(). $imagen; ?>">
					</div>

					<?php if ( $urlItem != "" || $linkType == "popup"): ?>
					</a>
					<?php endif ?>
					
					<?php if ( $show_title_item == 1 ): ?>
					<div class="item-slide-title">
						<?php echo $item->title; ?>
					</div>
					<?php endif; ?>

					<?php if ( $show_readmore_item == 1 && $source_content_link == 2 ): ?>
					<div class="item-slide-readmore">
						<a href="<?php echo $urlItem; ?>" class="btn btn-default" <?php if ($target_link == 2) { echo 'target="_blank"'; } ?>>
						<?php echo JTEXT::_("MOD_SLIDERSLICK_READMORE"); ?>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif ?>
		<?php endforeach ?>

	<?php endif ?>

</div>



<script>
(function($)
{
	$(document).ready(function()
	{

		$('#<?php echo $idName;?>').slick({
		  slidesToShow: <?php echo $slides_show; ?>,
		  accessibility: <?php echo $config_accessibility; ?>,
		  adaptiveHeight: <?php echo $config_adaptiveheight; ?>,
		  autoplay: <?php echo $config_autoplay; ?>,
		  arrows: <?php echo $config_arrows; ?>,
		  dots: <?php echo $config_dots; ?>,
		  infinite: true,
		  speed: 300,
		  centerMode: <?php echo $config_centermode; ?>,
		  variableWidth: <?php echo $config_variablewidth; ?>
		});	

		<?php
		if ( $linkType == "popup" ) { ?>

		$('.image-link.popup').magnificPopup({type:'image'});

		<?php } ?>

	})
})(jQuery);

</script>