<?php

/****************************************************************************************

    RilPoint MediaWiki Skin, based on the "Modern" skin, and "Bluemarine" Drupal Theme
    Copyright 2008, 2009 Ril Partner AB

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *****************************************************************************************/

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */
class SkinRilPoint extends SkinTemplate {
	/*
	 * We don't like the default getPoweredBy, the icon clashes with the 
	 * skin L&F.
	 */
/*
	function getPoweredBy() {
	global	$wgVersion;
		return "<div class='mw_poweredby'>Powered by MediaWiki $wgVersion</div>";
	}
*/
/*
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'rilpoint';
		$this->stylename = 'rilpoint';
		$this->template  = 'RilPointTemplate';
	}
*/

	var $skinname = 'rilpoint', $stylename = 'rilpoint',
		$template = 'RilPointTemplate', $useHeadElement = true;


	function setupSkinUserCss( OutputPage $out ) {
		global $wgHandheldStyle;

		parent::setupSkinUserCss( $out );

		// Append to the default screen common & print styles...
		$out->addStyle( 'rilpoint/style.css', 'screen' );
		$out->addStyle( 'rilpoint/print.css', 'print' );
		if( $wgHandheldStyle ) {
			// Currently in testing... try 'chick/main.css'
			$out->addStyle( $wgHandheldStyle, 'handheld' );
		}

		$out->addStyle( 'rilpoint/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'rilpoint/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'rilpoint/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'rilpoint/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'rilpoint/rtl.css', 'screen', '', 'rtl' );

	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class RilPointTemplate extends QuickTemplate {
	var $skin;
	/**
	 * Template filter callback for RilPoint skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgRequest;
		global $wgSitename;		
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

$this->html( 'headelement' );

?>

<table border="0" cellpadding="0" cellspacing="0" id="header">
  <tr>
    <td id="topnav-container" colspan="2">
          <div id="topnav">
      <!-- MW:personal portlet -->
	<div class="block" id="p-personal">
		<h2><?php $this->msg('personaltools') ?></h2>
		<div class="content">
			<ul class="menu">
<?php 			foreach($this->data['personal_urls'] as $key => $item) { ?>
				<li id="pt-<?php echo Sanitizer::escapeId($key) ?>"<?php
					if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
				echo htmlspecialchars($item['href']) ?>"<?php echo $skin->tooltipAndAccesskey('pt-'.$key) ?><?php
				if(!empty($item['class'])) { ?> class="<?php
				echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
				echo htmlspecialchars($item['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>
      <!-- /MW:personal portlet -->


          </div>
    </td>
  </tr>
  <tr>
    <td id="logo">
      <!-- MW:Logo -->
      <a href="<?php $this->text('scriptpath') ?>" title="Hem"><img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/logo.gif" alt="Hem"></a>
      <h1 class="site-name"><a href="<?php $this->text('scriptpath') ?>"><?php echo $wgSitename ?></a></h1>
      <!-- /MW:Logo -->
    </td>
    <td id="search-container">
    
    </td>
  </tr>
  <tr>
    <td colspan="2"><div><?php print $header ?></div>
   <div id="nav"> 
   <!-- MW:Main Tabs -->
   <?php
     $sidebar = $this->data['sidebar'];
     if ( isset( $sidebar['RILPOINT_TABS'] ) ) {
       $this->customBox( 'RILPOINT_TABS', $sidebar['RILPOINT_TABS'] );
     }
   ?>
   <!-- /MW:Main Tabs -->		
   </div>
    </td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" id="content">
  <tr>
    <td id="sidebar-left-container" class="sidebar-container"><div id="sidebar-left" class="sidebar">
      <!-- MW:Portlets -->
	<?php 
		$sidebar = $this->data['sidebar'];		
		if ( !isset( $sidebar['SEARCH'] ) ) $sidebar['SEARCH'] = true;
		if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
		if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;

		foreach ($sidebar as $boxName => $cont) {
			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} elseif ( $boxName == 'RILPOINT_TABS' ) {
				/* Nothing */				
			} else {
				$this->customBox( $boxName, $cont );
			}
		}
	?>
      <!-- /MW:Portlets -->
	
    </div><!-- #sidebar-left -->
    </td>
    <td valign="top">
      <div id="main-container">
        <div id="main">
           <!-- MW:Top boxes --> <!-- TODO: Find better place for these -->
		<div class='mw-topboxes' style='display: block; float: right;'>
			<!--<div class="mw-topbox" id="siteSub">--><?php /* $this->msg('tagline') */ ?><!--</div>-->
			<?php if($this->data['newtalk'] ) {
				?><div class="usermessage mw-topbox"><?php $this->html('newtalk')  ?></div>
			<?php } ?>
			<?php if($this->data['sitenotice']) {
				?><div class="mw-topbox" id="siteNotice"><?php $this->html('sitenotice') ?></div>
			<?php } ?>
		<!-- These don't belong here actually... -->
		<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
		<?php /* Jumplinks uncommented // SHL
		<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#mw_portlets"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?> */ 
		?>
		<!-- /These don't belong here actually... -->
		</div>
            <!-- /MW:Top boxes -->
                       
           <h1 class="title">
            <!-- MW:Page title -->
            <?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?>
            <!-- /MW:Page title -->
           </h1>
            <!-- MW:Tabs -->           
            <div class="tabs">
            <ul class="tabs">
  	    <?php		foreach($this->data['content_actions'] as $key => $tab) {
  					echo '
  				 <li id="ca-' . Sanitizer::escapeId($key).'"';
  					if( $tab['class'] ) {
  						echo ' class="'.htmlspecialchars($tab['class']).'"';
  					}
  					echo'><a href="'.htmlspecialchars($tab['href']).'"';
  					# We don't want to give the watch tab an accesskey if the
  					# page is being edited, because that conflicts with the
  					# accesskey on the watch checkbox.  We also don't want to
  					# give the edit tab an accesskey, because that's fairly su-
  					# perfluous and conflicts with an accesskey (Ctrl-E) often
  					# used for editing in Safari.
  				 	if( in_array( $action, array( 'edit', 'submit' ) )
  				 	&& in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
  				 		echo $skin->tooltip( "ca-$key" );
  				 	} else {
  				 		echo $skin->tooltipAndAccesskey( "ca-$key" );
  				 	}
  				 	echo '>'.htmlspecialchars($tab['text']).'</a></li>';
  				} ?> 
  	    </ul>                   
            </div>
            <!-- /MW:Tabs -->

            <!-- MW:Subtitle -->
            <?php $this->html('subtitle') ?>
            <div id="contentSub" style="display:none"><?php $this->html('subtitle') ?></div>	
            <!-- /MW:Subtitle -->                   

            <div class="content">
            <!-- MW:Content -->            
		<?php $this->html('bodytext') ?>
		<div class='mw_clear'></div>            
            <!-- /MW:Content -->            		
            </div>
	    <!-- MW:Cat links -->
            <?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
            <!-- /MW:Cat links -->

          </div>
          <!-- /Drupal node -->
        </div>
      </div>	
    </div>
    </td>
  </tr>
</table>

		
<div class="visualClear"></div>
<!-- MW:Footer -->
<div id="footer">
<?php
		if($this->data['poweredbyico']) { ?>
				<div id="f-poweredbyico"><?php $this->html('poweredbyico') ?></div>
<?php 	}
		if($this->data['copyrightico']) { ?>
				<div id="f-copyrightico"><?php $this->html('copyrightico') ?></div>
<?php	}

		// Generate additional footer links
?>
			<ul id="f-list">
<?php
		$footerlinks = array(
			'lastmod', 'viewcount', 'numberofwatchingusers', 'credits', 'copyright',
			'privacy', 'about', 'disclaimer', 'tagline',
		);
		foreach( $footerlinks as $aLink ) {
			if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
		}
?>
			</ul>
<!-- ?php /* -->
<!-- */ ? -->
</div>
<div class="ril-notice-tiny"><a href="http://rilpartner.se">Skin</a> by <a href="http://rilpartner.se">RIL Partner</a></div>
<!-- /MW:Footer -->



<!-- MW:After footer -->
<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif; ?>
<!-- /MW:After footer -->

</body>
</html>
<?php
	wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/
	function searchBox() {
?>
	<!-- search -->
	<div id="p-search" class="block">
		<h2><label for="searchInput"><?php $this->msg('search') ?></label></h2>
		<div id="searchBody" class="content">
			<form action="<?php $this->text('searchaction') ?>" id="searchform"><div>
				<input id="searchInput" name="search" type="text"<?php echo $this->skin->tooltipAndAccesskey('search');
					if( isset( $this->data['search'] ) ) {
						?> value="<?php $this->text('search') ?>"<?php } ?> />
				<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="<?php $this->msg('searcharticle') ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-go' ); ?> />&nbsp;
				<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-fulltext' ); ?> />
			</div></form>
		</div><!-- pBody -->
	</div><!-- portlet -->
<?php
	}

	/*************************************************************************************************/
	function toolbox() {
?>
	<!-- toolbox -->
	<div class="block" id="p-tb">
		<h2><?php $this->msg('toolbox') ?></h2>
		<div class="content">
			<ul class="menu">
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
					echo htmlspecialchars($feed['href']) ?>"<?php echo $this->skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $this->skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
		}

		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
?>			</ul>
		</div><!-- pBody -->
	</div><!-- portlet -->
<?php
	}

	/*************************************************************************************************/
	function languageBox() {
?>
	<!-- languages -->
<?php
		if( $this->data['language_urls'] ) { ?>
	<div id="p-lang" class="block">
		<h2><?php $this->msg('otherlanguages') ?></h2>
		<div class="content">
			<ul class="menu">
<?php		foreach($this->data['language_urls'] as $langlink) { ?>
				<li class="<?php echo htmlspecialchars($langlink['class'])?>"><?php
				?><a href="<?php echo htmlspecialchars($langlink['href']) ?>"><?php echo $langlink['text'] ?></a></li>
<?php		} ?>
			</ul>
		</div><!-- pBody -->
	</div><!-- portlet -->
<?php
		}
	}

	/*************************************************************************************************/
	function customBox( $bar, $cont ) {
?>
		<div class='generated-sidebar block' id='p-<?php echo Sanitizer::escapeId($bar) ?>'<?php echo $this->skin->tooltip('p-'.$bar) ?>>
		<h2><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo htmlspecialchars($bar); else echo htmlspecialchars($out); ?></h2>
		<div class='content'>
<?php   if ( is_array( $cont ) ) { ?>
			<ul class="menu">
<?php 			foreach($cont as $key => $val) { ?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php			} ?>
			</ul>
<?php   } else {
			# allow raw HTML block to be defined by extensions
			print $cont;
		} 
?>
		</div><!-- pBody -->
	</div><!-- portlet -->
<?php
	}

} // end of class
?>
