<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * This template is for the CSS WG blog.
 *
 * Author: Bert Bos <bert@w3.org>
 * Created: 16 September 2011
 *
 * Copyright © 2011 World Wide Web Consortium
 * See http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231
 *
 */

header("Not Implemented", true, 501);

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), " &ndash; Error</title>\n";

include 'head.inc';

echo "</head>\n";
echo "<body>\n";
echo "<h1><em>", get_bloginfo('name'), "</em> Error</h1>\n";

include 'intro.inc';

echo "<div class=\"section\">\n";
echo "<h2>Error</h2>\n\n";

echo "<p>The server could not handle this request.\n";
echo "This may be an error in the server, or it may\n";
echo "be an error on the page that you came from.\n";
echo "If you suspect it is the former, please\n";
echo "contact the maintainer, see the address\n";
echo "below.</p>\n";
echo "</div>\n\n";

include 'banner.en.inc';

echo "<div class=\"section\" id=\"endmatter\">\n";
include 'address.en.inc';
echo "<p>Last updated ", get_lastpostmodified(), "</p>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
