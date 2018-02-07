Copyright 2009-2018 Rich Morgan (rich@richmorgan.me)

Commonly used functions for PHP development aggregated within this class.  Hopefully these static classes will make life easier for those needing this functionality.  YMMV.





Usage
-----
Copy this file to your web directory.  Include() the file in the head of scripts that require the functionality or use an autoloader to load the class as-needed.  These functions are all static so there's no need to instantiate a new 'common' object.

Example:

```php
include_once('common.php');
$calendar = common::calendar;
```


Functions Provided
------------------
 - db_data_escape()
 - scrub()
 - blogscrub()
 - calendar()
 - parsedate()
 - encrypt()
 - decrypt()


Version
-------
 - 0.1, initial version
 - 0.2, Added encryption/decryption routines, Improved calendar code, Completed parsedate() function


License
-------
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
