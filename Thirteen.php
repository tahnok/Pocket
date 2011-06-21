<?php
  /**
   * Thirteen nouveau
   * Author:
   */

if( !defined( 'MEDIAWIKI' ) )
  die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 */
class SkinThirteen extends SkinTemplate {
  /** Using thirteen. */
  var $skinname = 'thirteen', $stylename = 'thirteen',
    $template = 'ThirteenTemplate', $useHeadElement = true;

  function setupSkinUserCss( OutputPage $out ) {

    $out->addStyle( 'thirteen/new.css', 'screen');
    //ensure screen is correct width on mobile devices"
    $out->addMeta( "viewport", "width = device-width");
  }
}

class ThirteenTemplate extends QuickTemplate {
  var $skin;
  /**
   * Template filter callback for Thirteen skin.
   * Takes an associative array of data set from a SkinTemplate-based
   * class, and a wrapper for MediaWiki's localization database, and
   * outputs a formatted page.
   *
   * @access private
   x     */
  function execute() {
    global $wgRequest;
    global $wgUser;
    $this->skin = $skin = $this->data['skin'];
    $action = $wgRequest->getText( 'action' );

    // Suppress warnings to prevent notices about missing indexes in $this->data
    wfSuppressWarnings();
    $this->html( 'headelement' );
    ?>
       <div id="globalWrapper">
           <div id="header">
	       <a href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>">
                   <img id="logo" alt="logo" src="<?php $this->text('stylepath') ?>/thirteen/banner.png"/>
	       </a>
           </div>
	   </div>
	   <?php $this->searchBox(); ?>
           <div id="column-content">
               <div id="content" <?php $this->html("specialpageattributes") ?>>
                   <a id="top"></a>
                   <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
                   <!--heading -->
                   <h1 id="firstHeading" class="firstHeading"><?php $this->html('title') ?></h1>
                   <div id="bodyContent">
                       <h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
                       <div id="contentSub"<?php $this->html('userlangattributes') ?>><?php $this->html('subtitle') ?></div>
                       <?php if($this->data['undelete']) { ?>
                        <div id="contentSub2"><?php $this->html('undelete') ?></div>
                        <?php } ?><?php if($this->data['newtalk'] ) { ?>
                        <div class="usermessage"><?php $this->html('newtalk')  ?></div>
                        <?php } ?>
                        <!-- start content -->
                        <?php $this->html('bodytext') ?>
                        <?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
                        <!-- end content -->
                        <?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
                    </div>
               </div>
           </div>
           <!-- End Content Div -->
           <!--Begin Sidebar / bottom bar stuff -->
           <div id="column-one"<?php $this->html('userlangattributes')  ?>>
	                      
               <div id="p-cactions" class="portlet">
                   <h5><?php $this->msg('views') ?></h5>
                   <div class="pBody">
                       <ul>
                           <li id="toggleActions"><a id="ta-link" href="#" onclick="javascript:return false">Menu [+]</a></li>
                           <div id="actions">
                               <?php
                                   foreach($this->data['content_actions'] as $key => $tab) {
                                       echo '<li id="' . Sanitizer::escapeId( "ca-$key" ) . '"';
                                       if( $tab['class'] ) {
                                         ' class="'.htmlspecialchars($tab['class']).'"';
                                       }
                                       echo '><a href="'.htmlspecialchars($tab['href']).'"';
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
                           </div>
                       </ul>
                   </div>
               </div>       
               <div class="portlet">
                   <h5><?php $this->msg('personaltools') ?></h5>
                   <div class="pBody">
                       <ul<?php $this->html('userlangattributes') ?>>
                           <?php if($wgUser->isLoggedIn()){ //  * Toggle buttons shouldn't display if there is only 1 item (ie the user is not logged in yet)
                               ?>
                               <li id="togglePersonal"><a href="#" id="tp-link"  onclick="javascript:return false">Tools [+]</a></li>
                               <div id="personalTools">
                           <?php } ?>
                           <?php foreach($this->data['personal_urls'] as $key => $item) {  ?>
                               <li id="<?php echo Sanitizer::escapeId( "pt-$key" ) ?>"<?php
                                   if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
                                       echo htmlspecialchars($item['href']) ?>"<?php echo $skin->tooltipAndAccesskey('pt-'.$key) ?><?php
                                   if(!empty($item['class'])) { ?> class="<?php
                                       echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
                                   echo htmlspecialchars($item['text']) ?></a></li>
                           <?php } ?>
                           <?php if($wgUser->isLoggedIn()){ ?>
                               </div>
                           <?php } ?>
                       </ul>
                   </div>
               </div>
               <script type="<?php $this->text('jsmimetype') ?>"> if (window.isMSIE55) fixalpha(); </script>
           </div>
           <!-- end of the left (by default at least) column -->
           <div id="siteInfo">
               For Copyright/FAQ/About see <?php global $wgSitename; echo $skin->link(Title::newFromText($wgSitename . ":Mobile About"), "About");?>
           </div>
       </div>
       <!-- End of Global Wrapper -->
       <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
       <?php $this->html('reporttime') ?>
       <?php if ( $this->data['debug'] ): ?>
       <!-- Debug output:
           <?php $this->text( 'debug' ); ?>
       -->
       <?php endif; ?>
       </body>

       <script type="text/javascript">
           $j("#toggleActions").click(function () {
	       var foo = document.getElementById("ta-link");
	       if( foo.innerHTML == "Menu [+]"){
		 foo.innerHTML = "Menu [-]";
	       }
	       else{
		 foo.innerHTML = "Menu [+]";
	       }
               $j("#actions").toggle();
             });

           $j("#togglePersonal").click(function () {
               $j("#personalTools").toggle();
               var foo = document.getElementById("tp-link");
	       if( foo.innerHTML == "Tools [+]"){
		 foo.innerHTML = "Tools [-]";
	       }
	       else{
		 foo.innerHTML = "Tools [+]";
	       }
             });
       </script>
    </html>
    <?php
    wfRestoreWarnings();
  } // end of execute() method

  /*************************************************************************************************/
  function searchBox() {
    global $wgUseTwoButtonsSearchForm;
    ?>
        <div id="p-search" class="portlet">
            <h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>
            <div id="searchBody" class="pBody">
                <form action="<?php $this->text('wgScript') ?>" id="searchform"'>
                    <input type='hidden' name="title" value="<?php $this->text('searchtitle') ?>"/>
                    <?php
                        echo Html::input( 'search',
                            isset( $this->data['search'] ) ? $this->data['search'] : '', 'search',
                            array(
                                'id' => 'searchInput',
                                'title' => $this->skin->titleAttrib( 'search' ),
                                'accesskey' => $this->skin->accesskey( 'search' ),
                                'size' => '20'
                    ) ); ?>
                    <input type='submit' name="go" class="searchButton" id="searchGoButton" value="Search"<?php echo $this->skin->tooltipAndAccesskey( 'search-go' ); ?> /><?php if ($wgUseTwoButtonsSearchForm) { ?>&nbsp;
                    <?php } else { ?>
                        <div><a href="<?php $this->text('searchaction') ?>" rel="search"><?php $this->msg('powersearch-legend') ?></a></div><?php } ?>
                </form>
            </div>
        </div>
    <?php
    }

  /*************************************************************************************************/
  function toolbox() {
      ?>
      <div class="portlet" id="p-tb">
          <h5><?php $this->msg('toolbox') ?></h5>
          <div class="pBody">
              <ul>
              <?php
                  if($this->data['notspecialpage']) { ?>
                      <li id="t-whatlinkshere"><a href="<?php
                      echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
                      ?>"<?php echo $this->skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
                      <?php
                      if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
                          <li id="t-recentchangeslinked"><a href="<?php
                              echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
                          ?>"<?php echo $this->skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked-toolbox') ?></a></li>
                      <?php }
                  }
                  if( isset( $this->data['nav_urls']['trackbacklink'] ) && $this->data['nav_urls']['trackbacklink'] ) { ?>
                      <li id="t-trackbacklink"><a href="<?php
                          echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
                          ?>"<?php echo $this->skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
                  <?php   }
                  if($this->data['feeds']) { ?>
                      <li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
                          ?><a id="<?php echo Sanitizer::escapeId( "feed-$key" ) ?>" href="<?php
                              echo htmlspecialchars($feed['href']) ?>" rel="alternate" type="application/<?php echo $key ?>+xml" class="feedlink"<?php echo $this->skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;
                      <?php } ?></li><?php
                  }
                  foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {
                      if($this->data['nav_urls'][$special]) {
                          ?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
                          ?>"<?php echo $this->skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
                      <?php }
                  }

                  if(!empty($this->data['nav_urls']['print']['href'])) { ?>
                      <li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
                      ?>" rel="alternate"<?php echo $this->skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
                  }

                  if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
                      <li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
                      ?>"<?php echo $this->skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
                  } elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
                      <li id="t-ispermalink"<?php echo $this->skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
                  }

                  wfRunHooks( 'ThirteenTemplateToolboxEnd', array( &$this ) );
                  wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
                  ?>
              </ul>
          </div>
      </div>
      <?php
  }

  /*************************************************************************************************/
  function customBox( $bar, $cont ) {
      ?>
      <div class='generated-sidebar portlet' id='<?php echo Sanitizer::escapeId( "p-$bar" ) ?>'<?php echo $this->skin->tooltip('p-'.$bar) ?>>
          <h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo htmlspecialchars($bar); else echo htmlspecialchars($out); ?></h5>
          <div class='pBody'>
              <?php if ( is_array( $cont ) ) { ?>
                  <ul>
                       <?php foreach($cont as $key => $val) { ?>
                           <li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
                               if ( $val['active'] ) { ?> class="active" <?php }
                                   ?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
                      <?php } ?>
                  </ul>
              <?php   } else {
                  # allow raw HTML block to be defined by extensions
                 print $cont;
              }
              ?>
          </div>
      </div>
      <?php
  }
} // end of class


