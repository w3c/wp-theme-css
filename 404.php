<?php
/**
 * The template for displaying 404 pages (Not Found). 
 *
 * This template is for the CSS WG blog.
 *
 * To do: escape text where needed (with esc_html()?)
 *
 * Author: Bert Bos <bert@w3.org>
 * Created: 15 September 2011
 *
 * Copyright © 2011 World Wide Web Consortium
 * See http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231
 *
 */

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), " &ndash; ";
echo "404 Not found</title>\n\n";

include 'head.inc';

echo "<body>\n";
echo "<h1><em>",  get_bloginfo('name'), "</em>\n";
echo "Page not found</h1>\n\n";

include 'intro.inc';

echo "<div class=\"section\">\n";
echo "<h2>“404 Not found”</h2>\n\n";

echo "<p>The page you requested could not be found.\n";
echo "If you believe this is an error on our server,\n";
echo "please contact the maintainer, see the contact\n";
echo "address below.</p>\n";
echo "</div>\n\n";

include 'banner.en.inc';

echo "<div class=\"section\" id=\"endmatter\">\n";
include 'address.en.inc';
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
