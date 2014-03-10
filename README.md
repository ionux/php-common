Copyright 2009-2014 Rich Morgan (rich.l.morgan (at) gmail.com)

Commonly used functions for PHP development aggregated within this class.  Hopefully these static classes will make life easier for those needing this functionality.


License
-------
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.


Usage
-----
Copy this file to your web directory.  Include() the file in the head of scripts that require the functionality or use an autoloader to load the class as-needed.  These functions are all static so there's no need to instantiate a new 'common' object.

Example:
<pre>
include_once('common.php');
$calendar = common::calendar;
</pre>


Functions Provided
------------------
 - db_data_escape($data)
 - scrub($data)
 - blogscrub($data)
 - calendar($debug='false',$timezone='UTC')
 - parsedate($date)
 - encrypt($text,$key='',$iv='',$bit_check=8,$cypher_type='MCRYPT_TRIPLEDES')
 - decrypt($encrypted_text,$key='',$iv='',$bit_check=8,$cypher_type='MCRYPT_TRIPLEDES')


Version
-------
 - 0.1, initial version
 - 0.2, Added encryption/decryption routines, Improved calendar code, Completed parsedate() function
