
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

= AUTHOR =
Samuel Lampa at RIL Partner AB - http://www.rilnet.com

= CONTACT =
Skin development forums: http://www.rilnet.com/en/forum
Documentation: http://wiki.rilnet.com/wiki/RilPoint/Documentation

= CHANGE HISTORY =

== v0.9.2 ==
* Fixed issue: Ordered list items should have numbers, not bullets
* Fixed issue: horizontal rules should not clear out floating blocks
* Removed unwanted styling on comments on Recent changes page
* Imported some general styles from monobook:
** Images, thumbs et.c.
** Tables
** User messages
** Emulated center
** TOC (Table Of Content) box 
** et.c.

== v0.9.1 ==
* Poweredby info in footer
* Red bullets in lists
* Category links now in bottom of page
* Red links to non-existing pages

== 2009-01-08: v0.9 ==
* Main tabs are now a block region instead of just "primary links"
* MediaWiki version

== 2009-01-07 v0.5 ==
First draft, released for Drupal 6 only

==Documentation==

For full documentation, see: http://wiki.rilnet.com/wiki/RilPoint/Documentation

===Installation===

*Unpack the content of the tar-gzip archive into your skins folder under your MediaWiki install folder.
*Set the <code>$wgDefaultSkin</code> variable in LocalSettings.php to "RilPoint".

Example:
 $wgDefaultSkin = 'rilpoint';

===Enabling Main tabs===

*Edit the article named MediaWiki:Sidebar, and add a section named "RILPOINT_TABS", where you place your links.

Example content of the MediaWiki:Sidebar article:
<pre>
* SEARCH
* navigation
** mainpage|mainpage-description
** currentevents-url|currentevents
** recentchanges-url|recentchanges
** randompage-url|randompage
* TOOLBOX
* LANGUAGES
* RILPOINT_TABS
** Main Page|Home
** Article 1|Article 1
** Article 2|Article 2
** Article 3|Article 3
** http://www.example.com|Example.Com
</pre>
