# Pocket #
Mobile Skin for MediaWiki

Author: Wesley Ellis (tahnok@gmail.com)

Required Version: Mediawiki v1.16

TODO:

* skin preferences
* mobile editor?
* better buttons
* TOC collapse automatically
* TOC styling

BUGS:

* Rich Text buttons do not work
* RTL probably doesn't work

## Setup: ##

### Enabling jQuery: ###
Add the following to your LocalSettings.php:

```
// Include jQuery
function wfIncludeJQuery() {
global $wgOut;
$wgOut->includeJQuery();
}
$wgExtensionFunctions[] = 'wfIncludeJQuery';
```

### Automatic Mobile Skin: ###
If you'd like for this skin to be enabled automatically when a user visits the site using a mobile device (including Android, iPhone/iPad and Blackberries) please add the following to LocalSettings.php

```
# to set default skin for mobile devices
$ua=$_SERVER["HTTP_USER_AGENT"];

if(stristr($ua,"Mobile")||stristr($ua,"iPad")||stristr($ua,"iPhone")||stristr($ua,"iPod")||stristr($ua,"BlackBerry")||stristr($ua,"Opera Mini")||stristr($ua,"Opera Mobile")||stristr($ua, "Opera Mobi")||stristr($ua,"Nokia")){
  $wgDefaultSkin = "pocket";
}
```

### Setting the logo: ###
place 40px x 200px png banner for your site in the folder and call it banner.png

### Mobile About Page: ###
There is a link the footer to a page containing copyright, FAQ, etc... information that will point at $SiteName:MobileAbout . Please make sure it exists

## License ##

This code is released under GPLv3. See the file named copying for the full license
